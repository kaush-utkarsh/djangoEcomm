import urllib2
import datetime
import json
from django.shortcuts import render,render_to_response
from django.contrib.sessions.models import Session
from django.contrib.auth.models import User
from django.contrib.auth.decorators import login_required
from django.http import HttpResponse
from django.views.decorators.csrf import csrf_exempt
from rest_framework.renderers import JSONRenderer
from rest_framework.parsers import JSONParser
from rest_framework.decorators import api_view
from .models import Cart,Cart_products,Subcart,Credit_balance,Transaction,Payment,User_meta
from methods import current_cart,add_to_subcart,add_to_cartproduct,get_cart, create_cart_response
from django.template import Context, Template, loader

baseurl = 'http://162.209.8.12:8080/'

def get_userid(request):
    session = Session.objects.get(session_key=request.session._session_key)
    session_data = session.get_decoded()
    uid = session_data.get('_auth_user_id')
    return uid

#An HttpResponse that renders its content into JSON.
class JSONResponse(HttpResponse):
    def __init__(self, data, **kwargs):
        content = JSONRenderer().render(data)
        kwargs['content_type'] = 'application/json'
        super(JSONResponse, self).__init__(content, **kwargs)

def get_search_url(string):
    if 'query' not in string.keys():
        url = baseurl
        if 'category' in string.keys():
            url = url + 'search?category=' + string['category']
    else:
        url = baseurl + 'search?query=' + string['query']
        if 'page' in string.keys():
            url = url + '&page=' + string['page']
        if 'category' in string.keys():
            url = url + '&category=' + string['category']
        if 'price_l' in string.keys():
             url = url + '&price_l=' + string['price_l']
        if 'price_h' in string.keys():
            url = url + '&price_h=' + string['price_h']
        if 'items' in string.keys():
            url = url + '&items=' + string['items']
    return url

def home(request):
    if request.user.is_authenticated():
        res = categories(request)
        user_id = get_userid(request)
        cart = Cart.objects.filter(userid=user_id)
        if len(cart)>0:
            cart_data = get_cart(cart[0])
            data = {
                "res": res,
                "cart": cart_data
            }
        else:
            data = {
                "res":res
            }
        return render(request, "nogpo/home.html", data)
    else:
        return render(request, "nogpo/login.html")

@login_required
def products(request):
    res = categories(request)
    user_id = get_userid(request)
    cart = Cart.objects.filter(userid=user_id)
    if len(cart)>0:
        cart_data = get_cart(cart[0])
        data = {
            "res": res,
            "cart": cart_data
        }
    else:
        data = {
        "res":res
        }
    return render(request, "nogpo/products.html", data)

@login_required
def products_details(request):
    res = categories(request)
    user_id = get_userid(request)
    cart = Cart.objects.filter(userid=user_id)
    if len(cart)>0:
        cart_data = get_cart(cart[0])
        data = {
            "res": res,
            "cart": cart_data
        }
    else:
        data = {
        "res":res
        }
    return  render(request, "nogpo/product.html",data)

def categories(request):
    re = urllib2.urlopen("http://162.209.8.12:8080/categories")
    jsn = json.load(re)
    final = list()
    for each in jsn:
	    if each["parent"] == 1:
		    each["child"] = list()
		    for second in jsn:
			    if each["unspsc"] == second["parent"]:
				    each["child"].append(second)
		    final.append(each)
    return final

def product(request, product_id):
    res = categories(request)
    if request.method == 'GET':
        product = urllib2.urlopen(baseurl+'product/'+product_id)
        user_id = get_userid(request)
        cart = Cart.objects.filter(userid=user_id)
        if len(cart) > 0:
            cart_data = get_cart(cart[0])
            data = {
                "data": json.load(product),
                "res": res,
                "cart": cart_data
            }
        else:
            data = {
                "data": json.load(product),
                "res": res
            }
        return  render(request, "nogpo/product.html", data)

def search(request):
    if request.method == 'GET':
        string = request.GET
        hiturl = get_search_url(string)
        result = urllib2.urlopen(hiturl)
        result_json = json.load(result)
        return JSONResponse(result_json['products'])

def get_supplier(request):
    if request.method == 'GET':
        url = baseurl + 'supplier'
        response = urllib2.urlopen(url)
        return JSONResponse(json.load(response))

@csrf_exempt
def add_to_cart(request):
    if request.method == 'POST':
        userid = get_userid(request)
        productid = request.POST.get('product_id', '')
        supplierid = request.POST.get('supplier_id','')
        product = urllib2.urlopen(baseurl+'product/'+productid)
        productinfo = json.load(product)
        price = productinfo['price']
        name = productinfo['name']
        no_of_items = request.POST.get('quantity', '')
        cartproduct_data = {
            'product_id': productid,
            'no_of_items': no_of_items,
            'price': price,
            'name': name
        }
        response = current_cart(userid,supplierid,float(price)*int(no_of_items),cartproduct_data)
        return HttpResponse(json.dumps(response))
    #     cart= Cart(userid=userid, status=0, checkout_date = datetime.datetime.today(),total_price=0)
    #     cart.save()
    #     subcart_data = {'supplierid':supplierid,'cart_id':cart.id,'total_price':float(price)*int(no_of_items)}
    #     subcart = add_to_subcart(subcart_data,cart)
    #     product_cart = add_to_cartproduct(cartproduct_data,subcart)
    #     response = {'id':cart.id,'userid':userid,'productid':productid,'no_of_items':no_of_items,'subcart':subcart}
    #     return  HttpResponse(json.dumps(price))
    # else:
    #     return render_to_response("nogpo/cart.html")
def empty_cart(request):
    if request.method == 'POST':
        userid = get_userid(request)
        cart = Cart.objects.get(userid=userid)
        cart.status = 1
        cart.save()
        return HttpResponse('Success')

# def add_to_existing_subcart(request):
#     if request.method == 'POST':
#         cart_id = request.POST.get('cart_id','')
#         productid = request.POST.get('productid','')
#         supplierid = request.POST.get('supplier_id','')
#         price = request.POST.get('price','')
#         no_of_items = request.POST.get('no_of_items','')
#         subcart_data = {'supplierid':supplierid,'total_price':float(price)*int(no_of_items)}
#         subcart_id = add_to_subcart(subcart_data)
#         cartproduct_data = {'subcart_id':subcart_id,'product_id':productid,'no_of_items':no_of_items}
#         product_cart = add_to_cartproduct(cartproduct_data)
#         response = {'id':cart.id,'userid':userid,'productid':productid,'no_of_items':no_of_items,'subcart':subcart_id}
#         return  HttpResponse(json.dumps(response))
#     else:
#         return render_to_response("nogpo/cart.html")


@csrf_exempt
def cart(request):
    res = categories(request)
    user_id = get_userid(request)
    cart = Cart.objects.filter(userid=user_id)
    if len(cart) > 0 :

        cart_data = get_cart(cart[0])
        data = {
            "res": res,
            "cart": cart_data
        }
    else:
        data = {
            "res": res
        }
    return render(request,"nogpo/cart.html", data)

@csrf_exempt
def checkout(request):
    res = categories(request)
    user_id = get_userid(request)
    cart = Cart.objects.filter(userid=user_id)
    if len(cart) > 0:

        cart_data = get_cart(cart[0])
        data = {
            "res": res,
            "cart":cart_data
        }
    else:
        data = {
            "res":res
        }
    return render(request,"nogpo/checkout.html", data)

@csrf_exempt
def credits(request):
    res = categories(request)
    user_id = get_userid(request)
    cart = Cart.objects.filter(userid=user_id)
    if len(cart)>0:
        cart_data = get_cart(cart[0])
        data = {
            "res": res,
            "cart":cart_data
        }
    else:
        data = {
         "res":res
        }
    return render(request,"nogpo/credits.html", data)

@csrf_exempt
def delete_from_cart(request):
    if request.method == 'POST':
        ids = request.POST.get('id')
        productid,supplierid = ids.split('_')
        userid = get_userid(request)
        cart = Cart.objects.get(userid=userid,status=0)
        subcart = Subcart.objects.get(cart_id_id=cart.id,supplierid=supplierid,status=0)
        product = Cart_products.objects.get(subcart_id_id = subcart.id,product_id=productid,status=0)
        product.status = 1
        product.save()
        response = create_cart_response(cart)
        return HttpResponse(json.dumps(response))

@csrf_exempt
def apply_for_credit(request):
    if request.method == 'POST':
        userid = get_userid(request)
        merchantid = request.POST.get('merchantid','')
        credit_asked = request.POST.get('credit_asked',0)
        credit_status = request.POST.get('credit_status',0)
        applied_date = datetime.datetime.now().strftime('%Y-%m-%d')
        request_msg = request.POST.get('request_msg','Please Grant me the requested credit')
        status = request.POST.get('status',0)

        credit = Credit_balance(userid=userid,merchantid=merchantid,credit_asked=credit_asked,credit_status=0,applied_date=applied_date,request_msg=request_msg)
        credit.save()

@csrf_exempt
def credit_request_clearance(request):
    if request.method == 'GET':
        number = 1
        merchantid = request.GET.get('merchantid','')
        credits = Credit_balance.objects.filter(merchantid=merchantid)
        for credit in credits:
            item = {'userid':credit.userid,'credit':credit.credit,'applied_date':credit.applied_date,'request_msg':credit.request_msg}
            total = {'number':number,'item':item}
            number = number +1
            full_list.append(total)
        return HttpResponse(json.dumps(full_list))
    if request.method == 'POST':
        userid = request.POST.get('userid','')
        merchantid = request.POST.get('merchantid','')
        response_msg = request.POST.get('response_msg','')
        credit_approved = request.POST.get('credit_approved','')
        credit_status = request.POST.get('credit_status',0)
        applied_date = request.POST.get('applied_date','')
        credit_expiry_date = request.POST.get('credit_expiry_date','')
        cleared_date = datetime.datetime.date()
        rejection_date = request.POST.get('rejection_date','')
        credit = Credit_balance.objects.get(merchantid=merchantid).filter(userid=userid).filter(applied_date=applied_date)
        credit.response_msg = response_msg
        credit.credit_status = credit_status
        credit.credit_expiry_date = credit_expiry_date
        credit.cleared_date = datetime.datetime.date()
        credit.rejection_date = rejection_date
        credit.credit_approved = credit_approved
        credit.save()
        response = {'credit_approved':credit_approved,'merchantid':merchantid,'response_msg':response_msg}
        return HttpResponse(json.dumps(response))

