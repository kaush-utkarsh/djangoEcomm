from django.shortcuts import render
from django.contrib.sessions.models import Session
from django.contrib.auth.models import User
import urllib2
import datetime
import json
from django.http import HttpResponse
from django.views.decorators.csrf import csrf_exempt
from rest_framework.renderers import JSONRenderer
from rest_framework.parsers import JSONParser
from rest_framework.decorators import api_view

session_key = '8cae76c505f15432b48c8292a7dd0e54'
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
        if 'page' in string.keys() and 'category' in string.keys():
            url = baseurl + 'search?query=' + string['query'] + '&page=' + string['page'] + '&category=' + string['category']
            return url
        elif 'page' in string.keys():
            url = baseurl + 'search?query=' + string['query'] + '&page=' + string['page']
            return url
        elif 'category' in string.keys():
            url = baseurl + 'search?query=' + string['query'] + '&category=' + string['category']
            return url
        elif 'query' in string.keys():
            url = baseurl + 'search?query=' + string['query']
            url = price_in_search_query(string,url)
            return url
        else:
            return baseurl

def price_in_search_query(string,url):
    return_url = url
    if 'price_l' in string.keys():
        return_url = return_url + '&price_l=' + string['price_l']
    if 'price_h' in string.keys():
        return_url = return_url + '&price_h=' + string['price_h']
    return return_url


def home(request):
    res = categories(request)
    print type(res), len(res)
    return render(request, "nogpo/home.html", {'res' : res})

def products(request):
    res = categories(request)
    print type(res), len(res)
    return render(request, "nogpo/products.html", {'res' : res})

def product_details(request):
    res = categories(request)
    print type(res), len(res)
    return  render(request, "nogpo/productdetails.html", {'res': res})

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

def product(request):
    ids = int(request.GET.get('id'))
    if request.method == 'GET':
        product = urllib2.urlopen(baseurl+'product/'+ids)
        return JSONResponse(product.json())

def search(request):
    if request.method == 'GET':
        string = request.GET
        hiturl = get_search_url(string)
        result = urllib2.urlopen(hiturl)
        return JSONResponse(result.json())

@csrf_exempt
def add_to_cart(request):
    if request.method == 'POST':
        userid = request.POST.get('customerid', '')
        productid = request.POST.get('productid', '')
        no_of_items = request.POST.get('no_of_items', '')

        cart= Cart(userid=userid, status=0, checkout_date = datetime.datetime.today(),total_price=0)
        cart.save()
        product = Cart_products(product_id=productid,no_of_items=no_of_items,status=0,date=datetime.datetime.today(),cart_id_id=cart.id)
        product.save()
        print cart.id
        response = {'id':cart.id,'userid':userid,'productid':productid,'no_of_items':no_of_items}
        return  HttpResponse(json.dumps(response))
    else:
        c = {}
        c.update(csrf(request))
        return render_to_response("nogpo/cart.html", c)

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
