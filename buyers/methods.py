import urllib2
import datetime
import json
from .models import Cart,Cart_products,Subcart,Credit_balance,Transaction,Payment
from django.template import Context, Template, loader

baseurl = 'http://162.209.8.12:8080/'

def current_cart(userid,supplierid,new_price,cartproduct_data):
    print "current_cart"
    try:
        cart = Cart.objects.get(userid = userid,status=0)
    except Cart.DoesNotExist:
        cart= None
    subcart_data = {'supplierid':supplierid,'cart_id':cart.id,'total_price':new_price}
    if cart is not None:
        print "in current_cart"
        response = current_sub_cart(supplierid,cart,new_price,cartproduct_data,subcart_data)
        cart.total_price = float(cart.total_price) + float(response.total_price)
        cart.save()
        res = create_cart_response(cart)
        return res
    else:
        cart= Cart(userid=userid, status=0, checkout_date = datetime.datetime.today(),total_price=float(price)*int(no_of_items))
        cart.save()
        subcart = add_to_subcart(subcart_data,cart)
        price,product_cart = add_to_cartproduct(cartproduct_data,subcart)
        response = {'id':cart.id,'userid':userid,'productid':productid,'no_of_items':no_of_items,'subcart':subcart}
        res = create_cart_response(cart)
        return res
        # return False



def current_sub_cart(supplierid,cart,new_price,cartproduct_data,subcart_data):
    print "in sub cart"
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
        print "in else"
        subcart = add_to_subcart(subcart_data,cart)
        new_price,product = add_to_cartproduct(cartproduct_data,subcart)
        subcart.total_price = new_price
        subcart.save()
        return subcart

def check_cart_products(subcart,cartproduct_data):
    try:
        product = Cart_products.objects.get(subcart_id_id=subcart.id,product_id=cartproduct_data['product_id'])
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
    product = Cart_products(subcart_id=subcart,product_id=data['product_id'],no_of_items=data['no_of_items'],status=0,date=datetime.datetime.today(),price=data['price'])
    product.save()
    new_price = int(data['no_of_items']) * float(data['price'])
    return new_price,product

def create_cart_response(cart):
    total_quantity = 0
    print 'create_cart_response'
    topsidebar = loader.get_template('nogpo/cart_topsidebar.html')
    mobile = loader.get_template('nogpo/cart_mobile.html')

    cart_data = {}
    product_array = list()
    subcarts = Subcart.objects.filter(cart_id_id=cart.id)
    for subcart in subcarts:
        products = Cart_products.objects.filter(subcart_id_id=subcart.id)
        product_return_data = {}
        for product in products:
            url = baseurl+'product/'+str(product.product_id)
            print url
            p = urllib2.urlopen(url)
            print p
            productinfo = json.load(p)
            quant = str(product.no_of_items)
            total_quantity = long(total_quantity) + long(quant)
            product_return_data['product_url'] = 'product/' + str(product.id)
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

    print type(cart_data)
    print cart_data['total_no_items']
    d = {"product_name": "Nokia"}

    response = {
        'status':'SUCCESS',
        'message':'was added to your shopping cart.',
        'sidebar': topsidebar.render(cart_data),
        'topcart_mobile_block': mobile.render(cart_data)
    }
    return response
