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

