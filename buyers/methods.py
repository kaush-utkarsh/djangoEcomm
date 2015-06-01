import urllib2
import datetime
import json
from .models import Cart,Cart_products,Subcart,Credit_balance,Transaction,Payment
from django.template import Context, Template, loader

baseurl = 'http://162.209.8.12:8080/'

def current_cart(userid,supplierid,new_price,cartproduct_data):
    try:
        cart = Cart.objects.get(userid = userid,status=0)
    except Cart.DoesNotExist:
        cart= Cart(userid=userid, status=0, checkout_date = datetime.datetime.now().strftime('%Y-%m-%d'),total_price=float(cartproduct_data['price'])*int(cartproduct_data['no_of_items']))
        cart.save()
    subcart_data = {'supplierid':supplierid,'cart_id':cart.id,'total_price':new_price}
    if cart is not None:
        response = current_sub_cart(supplierid,cart,new_price,cartproduct_data,subcart_data)
        cart.total_price = float(cart.total_price) + float(response.total_price)
        cart.save()
        update_cart_price(cart)
        res = create_cart_response(cart)
        return res
    else:
        subcart = add_to_subcart(subcart_data,cart)
        price,product_cart = add_to_cartproduct(cartproduct_data,subcart)
        response = {'id':cart.id,'userid':userid,'productid':productid,'no_of_items':no_of_items,'subcart':subcart}
        update_cart_price(cart)
        res = create_cart_response(cart)
        return res

def current_sub_cart(supplierid,cart,new_price,cartproduct_data,subcart_data):
    try:
        subcart = Subcart.objects.get(cart_id_id = cart.id,supplierid = supplierid)
    except Subcart.DoesNotExist:
        subcart = None
    if subcart is not None:
        new_price,product = check_cart_products(subcart,cartproduct_data)
        subcart.total_price = float(new_price) + float(subcart.total_price)
        subcart.save()
        return subcart
    else:
        subcart = add_to_subcart(subcart_data,cart)
        new_price,product = add_to_cartproduct(cartproduct_data,subcart)
        subcart.total_price = new_price
        subcart.save()
        return subcart

def check_cart_products(subcart,cartproduct_data):
    try:
        product = Cart_products.objects.get(subcart_id_id=subcart.id,product_id=cartproduct_data['product_id'],status=0)
    except Cart_products.DoesNotExist:
        product = None
    if product is not None:
        new_price = int(cartproduct_data['no_of_items']) * float(cartproduct_data['price'])
        product.no_of_items = product.no_of_items + long(cartproduct_data['no_of_items'])
        product.save()
        return new_price,product
    else:
       new_price,product = add_to_cartproduct(cartproduct_data,subcart)
       return new_price,product

def add_to_subcart(data,cart):
    subcart = Subcart(supplierid=data['supplierid'],cart_id=cart,total_price=data['total_price'],status=0)
    subcart.save()
    return subcart

def add_to_cartproduct(data,subcart):
    product = Cart_products(subcart_id=subcart,product_id=data['product_id'],no_of_items=data['no_of_items'],status=0,date=datetime.datetime.now().strftime('%Y-%m-%d'),price=data['price'])
    product.save()
    new_price = int(data['no_of_items']) * float(data['price'])
    return new_price,product

def create_cart_response(cart):
    total_quantity = 0
    topsidebar = loader.get_template('nogpo/cart_topsidebar.html')
    mobile = loader.get_template('nogpo/cart_mobile.html')
    cart_data = get_cart(cart)

    response = {
        'status':'SUCCESS',
        'message':'was added to your shopping cart.',
        'sidebar': topsidebar.render(Context(cart_data)),
        'topcart_mobile_block': mobile.render(Context(cart_data))
    }

    return response

def get_cart(cart):
    total_quantity = 0
    cart_data = {}
    product_array = list()
    subcarts = Subcart.objects.filter(cart_id_id=cart.id,status=0)
    for subcart in subcarts:
        products = Cart_products.objects.filter(subcart_id_id=subcart.id,status=0)
        product_return_data = {}
        for product in products:
            url = baseurl+'product/'+str(product.product_id)
            p = urllib2.urlopen(url)
            productinfo = json.load(p)
            quant = str(product.no_of_items)
            total_quantity = long(total_quantity) + long(quant)
            product_return_data['product_url'] = 'product/' + str(product.product_id)
            product_return_data['supplierid'] = subcart.supplierid
            product_return_data['product_id'] = str(product.product_id)
            product_return_data['delete_url'] = 'Yet to do'
            product_return_data['product_image'] = 'http://www.mendell.com/images/Orthopedics.jpg'
            product_return_data['product_name'] = productinfo['name']
            product_return_data['quantity'] = str(product.no_of_items)
            product_return_data['price'] = float(product.price)
            product_array.append(product_return_data)

    cart_data['total_no_items'] = total_quantity
    cart_data['products'] = product_array
    cart_data['total_price'] = float(cart.total_price)
    cart_data['checkout_url'] = 'yet to do'
    cart_data['cart_url'] = 'yet to do'

    return cart_data

def update_cart_price(cart):
    total_price = 0
    subcarts = Subcart.objects.filter(cart_id_id=cart.id,status=0)
    subcart_price = 0
    for subcart in subcarts:
        products = Cart_products.objects.filter(subcart_id_id=subcart.id,status=0)
        product_price = 0
        for product in products:
            product_price = product_price + (float(product.no_of_items ) * float(product.price))
        subcart_price = subcart_price + product_price
        # print subcart_price
    total_price = subcart_price
    # print total_price
    cart.total_price = total_price
    # print cart.total_price
    cart.save()
    return