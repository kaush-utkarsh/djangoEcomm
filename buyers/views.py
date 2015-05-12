from django.shortcuts import render,render_to_response
from django.contrib.sessions.models import Session
from django.contrib.auth.models import User
from django.contrib.auth.decorators import login_required
import urllib2
import datetime
import json
from django.http import HttpResponse
from django.views.decorators.csrf import csrf_exempt
from rest_framework.renderers import JSONRenderer
from rest_framework.parsers import JSONParser
from rest_framework.decorators import api_view

baseurl = 'http://162.209.8.12:8080/'

#An HttpResponse that renders its content into JSON.
class JSONResponse(HttpResponse):
    def __init__(self, data, **kwargs):
        content = JSONRenderer().render(data)
        kwargs['content_type'] = 'application/json'
        super(JSONResponse, self).__init__(content, **kwargs)

def get_userid(request):
    session = Session.objects.get(session_key=request.session._session_key)
    session_data = session.get_decoded()
    print session_data
    uid = session_data.get('_auth_user_id')
    print uid
    return uid

def get_search_url(string):
    if 'query' not in string.keys():
        return baseurl
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
        return url

def home(request):
    res = categories(request)
    print type(res), len(res)
    if request.user.is_authenticated():
        return render(request, "nogpo/home.html", {'res' : res})
    else:
        return render(request, "registration/login.html")

@login_required
def products(request):
    res = categories(request)
    print type(res), len(res)
    return render(request, "nogpo/products.html", {'res' : res})

@login_required
def products_details(request):
    res = categories(request)
    print type(res), len(res)
    return  render(request, "nogpo/product.html", {'res': res})

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
    # ids = int(request.GET.get('id'))
    print product_id
    if request.method == 'GET':
        product = urllib2.urlopen(baseurl+'product/'+product_id)
        # print json.load(product)
        data = {
            "data": json.load(product)
        }
        return  render(request, "nogpo/product.html", data)

def search(request):
    if request.method == 'GET':
        string = request.GET
        hiturl = get_search_url(string)
        result = urllib2.urlopen(hiturl)
        print result
        return JSONResponse(json.load(result))

@csrf_exempt
def add_to_cart(request):
    if request.method == 'POST':
        userid = request.POST.get('customerid', '')
        productid = request.POST.get('productid', '')
        no_of_items = request.POST.get('no_of_items', '')
        userid = get_userid()
        # total_price = baseurl + send request to get product price
        cart= Cart(userid=userid, status=0, checkout_date = datetime.datetime.today(),total_price=0)
        cart.save()
        product = Cart_products(product_id=productid,no_of_items=no_of_items,status=0,date=datetime.datetime.today(),cart_id_id=cart.id)
        product.save()
        print cart.id
        response = {'id':cart.id,'userid':userid,'productid':productid,'no_of_items':no_of_items}
        return  HttpResponse(json.dumps(response))
    else:
        return render_to_response("nogpo/cart.html")

@csrf_exempt
def edit_cart(request):
    if request.method == 'POST':
        cartid = request.POST.get('cartid','')
        productid = request.POST.get('productid', '')
        no_of_items = request.POST.get('no_of_items', '')

        product = Cart_products.objects.get(cart_id_id=cartid)
        product.productid = productid
        product.no_of_items = no_of_items
        product.save()
        response = {'id':cartid,'productid':productid,'no_of_items':no_of_items}
        return HttpResponse(json.dumps(response))

@csrf_exempt
def delete_from_cart(request):
    if request.method == 'POST':
        cartid = request.POST.get('cartid','')
        cart = Cart.objects.get(id = cartid)
        cart.delete()
        return render(request,"nogpo/cart.html")
        productid = request.POST.get('productid','')
        products = Cart_products.objects.filter(cart_id_id = cartid).filter(product_id=productid)
        for product in products:
            # print p.product_id
            product.status = 1
            product.save()
        return render(request,"nogpo/cart.html")

@csrf_exempt
def get_cart(request):
    if request.method == 'POST':
        number = 1
        item = {}
        full_list = list()
        cartid = request.POST.get('cartid','')
        products = Cart_products.objects.filter(cart_id_id=cartid)
        for product in products:
            item = {'id':product.id,'productid':product.product_id,'no_of_items':product.no_of_items,'date':product.date.strftime('%Y/%m/%d')}
            total = {'number':number,'item':item}
            number = number + 1
            full_list.append(total)
        # response = {'items':product}
        return HttpResponse(json.dumps(full_list))

@csrf_exempt
def apply_for_credit(request):
    if request.method == 'POST':
        userid = request.POST.get('userid','')
        merchantid = request.POST.get('merchantid','')
        credit_asked = request.POST.get('credit_asked',0)
        credit_status = request.POST.get('credit_status',0)
        applied_date = datetime.datetime.date()
        request_msg = request.POST.get('request_msg','Please Grant me the requested credit')
        status = request.POST.get('status',1)

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

