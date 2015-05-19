from .models import Cart,Cart_products,Subcart,Credit_balance,Transaction,Payment
from views import add_to_cartproduct,add_to_subcart


def current_cart(userid,supplierid,new_price,cartproduct_data):
    cart = Cart.objects.filter(userid = userid).filter(status=0)
    if cart:
        #check for sub cart for the same seller
        current_sub_cart(supplierid,cart,new_price,cartproduct_data)
        return True
    else:
        return False



def current_sub_cart(supplierid,cart,new_price,cartproduct_data):
    # check if supplier exist then update total price
    subcart = Subcart.objects.filter('cart_id'=cart).filter('supplierid'=supplierid)
    if subcart:
        # also add cart product
        subcart.total_price = subcart.total_price + new_price
        subcart.save()
        product = add_to_cartproduct(cartproduct_data,subcart)
        return True
    else:
        # create new subcart
        # add cart product
        subcart = add_to_subcart(subcart_data,cart)
        product = add_to_cartproduct(cartproduct_data,subcart)
        return False
