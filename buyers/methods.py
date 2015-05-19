import urllib2
import datetime
import json
from .models import Cart,Cart_products,Subcart,Credit_balance,Transaction,Payment


def current_cart(userid,supplierid,new_price,cartproduct_data):
    try:
        cart = Cart.objects.get(userid = userid,status=0)
    except Cart.DoesNotExist:
        cart = None
    subcart_data = {'supplierid':supplierid,'cart_id':cart.id,'total_price':new_price}
    if cart is not None:
        print "in current_cart"
        response = current_sub_cart(supplierid,cart,new_price,cartproduct_data,subcart_data)
        print response.total_price
        print cart.total_price
        cart.total_price = float(cart.total_price) + float(response.total_price)
        print cart.total_price
        cart.save()
        return True
    else:
        print "here"
        cart= Cart(userid=userid, status=0, checkout_date = datetime.datetime.today(),total_price=float(price)*int(no_of_items))
        cart.save()
        subcart = add_to_subcart(subcart_data,cart)
        product_cart = add_to_cartproduct(cartproduct_data,subcart)
        response = {'id':cart.id,'userid':userid,'productid':productid,'no_of_items':no_of_items,'subcart':subcart}
        return False



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