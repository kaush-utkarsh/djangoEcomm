from django.shortcuts import render
import urllib2
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
    return render(request, "nogpo/home.html", {'categories' : res})

def products(request):
    return render(request, "nogpo/products.html")

def product_details(request):
    return  render(request, "nogpo/productdetails.html")

def categories(request):
    re = urllib2.urlopen("http://162.209.8.12:8080/categories")
    jsn = re.json()
    final = list()
    for each in jsn:
	    if each["parent"] == 1:
		    each["child"] = list()
		    for second in jsn:
			    if each["unspsc"] == second["parent"]:
				    each["child"].append(second)
		    final.append(each)
    return json.dumps(final)

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

        cart= Cart(userid=userid, productid=productid, no_of_items = no_of_items)
        cart.save()
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

        cart = Cart.objects.get(id=cartid)
        cart.productid = productid
        cart.no_of_items = no_of_items
        cart.save()
        response = {'id':cart.id,'productid':productid,'no_of_items':no_of_items}
        return HttpResponse(json.dumps(response))

@csrf_exempt
def delete_from_cart(request):
    if request.method == 'POST':
        cartid = request.POST.get('cartid','')
        cart = Cart.objects.get(id = cartid)
        cart.delete()
        return render(request,"nogpo/cart.html")
