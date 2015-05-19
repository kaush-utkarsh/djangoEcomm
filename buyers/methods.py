from .models import Cart,Cart_products,Subcart,Credit_balance,Transaction,Payment
# from views import add_to_cartproduct,add_to_subcart


def current_cart(userid,supplierid,new_price,cartproduct_data):
    print "yo"
    cart = Cart.objects.get(userid = userid,status=0)
    if cart is not None:
        #check for sub cart for the same seller
        print "in current_cart"
        response = current_sub_cart(supplierid,cart,new_price,cartproduct_data)
        print response
        return True
    else:
        print "here"
        return False



def current_sub_cart(supplierid,cart,new_price,cartproduct_data):
    # check if supplier exist then update total price

    print "in sub cart"
    subcart = Subcart.objects.get(cart_id_id = cart.id,supplierid = supplierid)
    if subcart is not None:
        # also add cart product
        new_price,product = check_cart_products(subcart,cartproduct_data)
        subcart.total_price = float(new_price) + float(subcart.total_price)
        subcart.save()
        # product = add_to_cartproduct(cartproduct_data,subcart)
        return True
    else:
        # create new subcart
        # add cart product
        subcart = add_to_subcart(subcart_data,cart)
        new_price,product = add_to_cartproduct(cartproduct_data,subcart)
        subcart.total_price = new_price
        subcart.save()
        return False

def check_cart_products(subcart,cartproduct_data):
    product = Cart_products.objects.get(subcart_id_id=subcart.id,product_id=cartproduct_data['product_id'])
    print type(product.no_of_items)
    if product is not None:
        new_price = int(cartproduct_data['no_of_items']) * float(cartproduct_data['price'])
        product.no_of_items = product.no_of_items + long(cartproduct_data['no_of_items'])
        product.save()
        return new_price,product
    else:
       new_price,product = add_to_cartproduct(cartproduct_data,subcart)
       return new_price,product

def add_to_subcart(data,cart):
    # print data
    subcart = Subcart(supplierid=data['supplierid'],cart_id=cart,total_price=data['total_price'],status=0)
    subcart.save()
    # print "working"
    return subcart

def add_to_cartproduct(data,subcart):
    product = Cart_products(subcart_id=subcart,product_id=data['product_id'],no_of_items=data['no_of_items'],status=0,date=datetime.datetime.today(),price=data['price'])
    product.save()
    new_price = data['no_of_items'] * data['price']
    return new_price,product