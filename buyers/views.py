import urllib2
import datetime
import json
from django.core.mail import send_mail
from django.shortcuts import render,render_to_response,HttpResponseRedirect
from django.contrib.sessions.models import Session
from django.contrib.auth.models import User
from django.contrib.auth.decorators import login_required
from django.http import HttpResponse,HttpResponseRedirect
from django.views.decorators.csrf import csrf_exempt
from rest_framework.renderers import JSONRenderer
from rest_framework.parsers import JSONParser
from rest_framework.decorators import api_view
from .models import Cart,Cart_products,Subcart,Credit_balance,Transaction,Payment,User_meta,Hospitals,Ecommerce_user_hospital_link
from methods import current_cart,add_to_subcart,add_to_cartproduct,get_cart, create_cart_response,update_cart_price
from django.template import Context, Template, loader
from credit import current_credit
from hospitals import get_hospital,get_hospital_link
from usermeta import user_meta_data
from random import randrange
from registration.models import RegistrationProfile 
# import inspect

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
        if 'categories' in string.keys():
            url = url + 'search?categories=' + string['categories']
    else:
        url = baseurl + 'search?query=' + string['query']
        if 'page' in string.keys():
            url = url + '&page=' + string['page']
        if 'categories' in string.keys():
            url = url + '&categories=' + string['categories']
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
    filter_data = search_backend(request)
    print filter_data
    user_id = get_userid(request)
    cart = Cart.objects.filter(userid=user_id)
    if len(cart)>0:
        cart_data = get_cart(cart[0])
        # print cart_data
        data = {
            "res": res,
            "cart": cart_data,
            "filters":filter_data['filters']
        }
    else:
        data = {
        "res":res,
        "filters":filter_data['filters']
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

def subcategory(request):
    subcategory_id = request.GET.get('subcategory','')
    res = categories(request)
    user_id = get_userid(request)
    cart = Cart.objects.filter(userid=user_id)
    if subcategory_id != '':
        sub_id = subcategory_id
    else:
        sub_id = '0'
    if len(cart)>0:
        cart_data = get_cart(cart[0])
        data = {
            "res":res,
            "cart":cart_data,
            "subcategory":int(sub_id)
        }
    else:
        data = {
        "res":res,
        "subcategory":int(sub_id)

        }
    return render(request,"nogpo/subcategory.html",data)

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

def search_backend(request):
    string = request.GET
    hiturl = get_search_url(string)
    result = urllib2.urlopen(hiturl)
    result_json = json.load(result)
    return result_json

def search(request):
    if request.method == 'GET':
        # print "work"
        url = baseurl + 'search?'
        string = request.GET
        for a in string:
            values = request.GET.getlist(a)
            val = ''
            for v in values:
                if val == '':
                    val = v
                else:
                    val = val + "|" + v
            # print val
            url = url + a + '=' + val + '&'
        # print url
        result = urllib2.urlopen(url)
        result_json = json.load(result)
        # print result_json
        return JSONResponse(result_json)
        # return HttpResponse('work')

def get_supplier(request):
    if request.method == 'GET':
        url = baseurl + 'supplier'
        response = urllib2.urlopen(url)
        return json.load(response)

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

def empty_cart(request):
    if request.method == 'POST':
        userid = get_userid(request)
        cart = Cart.objects.get(userid=userid)
        cart.status = 1
        cart.save()
        return HttpResponse('Success')


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
    credits = current_credit(user_id,request)
    if len(cart) > 0:
        cart_suppliers = []
        credit_sellers = []
        cart_data = get_cart(cart[0])
        supplier_price = {}
        for credit in credits:
            if credit['supplierid'] not in credit_sellers:
                credit_sellers.append(credit['supplierid'])
        for cart in cart_data['products']:
            print cart
            if cart['supplierid'] not in cart_suppliers:
                cart_suppliers.append(cart['supplierid'])
                supplier_price[cart['supplierid']] = cart['price']
            else:
                supplier_price[cart['supplierid']] = supplier_price[cart['supplierid']] + cart['price']

        data = {
            "res": res,
            "cart":cart_data,
            "credits":credits,
            "user_id":user_id,
            "cart_supplier" : cart_suppliers,
            "supplier_price" : supplier_price,
            "credit_sellers": credit_sellers
        }
    else:
        data = {
            "res":res,
            "credits":credits,
            "user_id":user_id,
        }
    return render(request,"nogpo/checkout.html", data)

@csrf_exempt
def credits(request):
    if request.method == "GET":
        res = categories(request)
        suppliers = get_supplier(request)
        user_id = get_userid(request)
        cart = Cart.objects.filter(userid=user_id,status=0)
        credits = current_credit(user_id)
        # print credits
        if len(cart)>0:
            cart_data = get_cart(cart[0])
            data = {
                "res": res,
                "cart":cart_data,
                "suppliers":suppliers,
                "credits": credits
            }
        else:
            data = {
             "res":res,
             "suppliers":suppliers,
             "credits":credits
            }
        return render(request,"nogpo/credits.html", data)
    if request.method == "POST":
        # print "in post"
        userid = get_userid(request)
        merchantid = request.POST.get('merchantid','')
        credit_requested = int(request.POST.get('credit_requested','0'))
        credit_status = request.POST.get('credit_status',0)
        applied_date = datetime.datetime.now().strftime('%Y-%m-%d')
	cleared_date = datetime.datetime.now().strftime('%Y-%m-%d')
	credit_expiry_date = datetime.datetime.now().strftime('%Y-%m-%d')
        request_msg = request.POST.get('request_msg','Please Grant me the requested credit')
        status = request.POST.get('status',0)
        credit = Credit_balance(userid=userid,merchantid=merchantid,credit_requested=credit_requested,credit_status=0,applied_date=applied_date,request_msg=request_msg,credit_approved=0,Cleared_date=cleared_date,credit_expiry_date=credit_expiry_date)
        credit.save()
        # print credit       
        return HttpResponseRedirect("/")

def hospital(request):
    if request.method == "GET":
        user_id = get_userid(request)
        res = categories(request)
        hospitals = get_hospital(request)
        user_hospital = get_hospital_link(user_id)
        cart = Cart.objects.filter(userid=user_id,status=0)
        if len(cart) > 0:
            cart_data = get_cart(cart[0])
            data = {
                "res": res,
                "cart":cart_data,
                "hospitals":hospitals,
                "hospital_links":user_hospital
            }
        else:
            data = {
                "res": res,
                "hospitals":hospitals,
                "hospital_links":user_hospital
            }
        return render(request,"nogpo/hospital.html",data)
    if request.method == "POST":
        userid = get_userid(request)
        hospital_id = request.POST.get('hospital_id','')
        # print hospital_id
        # print userid
        relation = Ecommerce_user_hospital_link(user_id=userid,hospital_id=hospital_id)
        relation.save()
        return HttpResponseRedirect('/')

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
        subcart.status = 1
        subcart.save()
        update_cart_price(cart)
        response = create_cart_response(cart)
        return HttpResponse(json.dumps(response))


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
        credit = Credit_balance.objects.get(merchantid=merchantid).filter(userid=userid)
        credit.response_msg = response_msg
        credit.credit_status = credit_status
        credit.credit_expiry_date = credit_expiry_date
        credit.cleared_date = datetime.datetime.date()
        credit.rejection_date = rejection_date
        credit.credit_approved = credit_approved
        credit.save()
        response = {'credit_approved':credit_approved,'merchantid':merchantid,'response_msg':response_msg}
        return HttpResponse(json.dumps(response))

@csrf_exempt
def meta(request):
    # data = request
    # print data
    response = user_meta_data(request)
    # print response
    return HttpResponse(json.dumps(response))

def best_sellers(request):
    if request.method == "GET":
        print "in here"
        url = baseurl +"best-seller"
        result = urllib2.urlopen(url)
        response = json.load(result)
        # print response
        return HttpResponse(json.dumps(response))

def new_products(request):
    if request.method == "GET":
        print "in here 2 "
        url = baseurl +"new-products"
        result = urllib2.urlopen(url)
        response = json.load(result)
        # print response
        return HttpResponse(json.dumps(response))

def top_rated(request):
    if request.method == "GET":
        print "in here 3"
        url = baseurl +"top-rated"
        result = urllib2.urlopen(url)
        response = json.load(result)
        # print response
        return HttpResponse(json.dumps(response))

def purchase(request):
    data = request.GET
    print data
    return render_to_response('/')

@csrf_exempt
def contact(request):
    errors = []
    if request.method == 'GET':
        return render_to_response('nogpo/contact.html')
    if request.method == 'POST':
        if not request.POST.get('subject',''):
            errors.append('Enter a subject.')
        if not request.POST.get('message',''):
            errors.append('Enter a message')
        if request.POST.get('email') and '@' not in request.POST['email']:
            errors.append('enter a valid e-mail address.')
        if not errors:
            send_mail(
                    request.POST['subject'],
                    request.POST['message'],
                    request.POST.get('email','nonreply@nogpo.com'),
                    ['administrator@nogpo.com'],
                    )
            return HttpResponseRedirect('/thanks/')
        return render(request,'nogpo/contact.html',{'errors':errors})

def thanks(request):
    return render_to_response('nogpo/thanks.html')

@csrf_exempt
def seller_credit_payment(request):
    if request.method == 'POST':
        seller_details = request.POST
        seller_details = json.loads(seller_details['seller_det'])
        summ = 0
        for seller in seller_details:
            seller_id = seller['name']
            seller_credit = float(seller['value'])
            p_id = randrange(199999, 1000000)
            userid = get_userid(request)
            cart = Cart.objects.get(userid=userid,status=0)
            total_credit = 0
            cart_data = get_cart(cart)
            supplier_price = {}
            for crt in cart_data['products']:
                if crt['supplierid'] == seller_id:
                    if crt['price']<float(seller_credit):
                        total_credit = total_credit+crt['price']
                    else:
                        total_credit = total_credit+(crt['price']- float(seller_credit))
            summ = summ + total_credit
            summ = cart_data['total_price'] - summ
            subcart = Subcart.objects.get(cart_id=cart,supplierid=seller_id)
            transact = Transaction(cart_id = cart, status = 0 )
            transact.save()
            payment = Payment(payment_id = p_id, method = "seller_credit", ammount = total_credit, transaction_id = transact, method_id = "", subcart_id = subcart)
            payment.save()
            result = update_credit(seller_id,total_credit,request)
            print result
        return HttpResponse(summ)

def related_products(request):
    if request.method == 'GET':
        unspsc = request.GET.get('unspsc')
        url = baseurl + 'related-products/'+unspsc
        result = urllib2.urlopen(url)
        response = json.load(result)
        # print response
        return HttpResponse(json.dumps(response))

def update_credit(merchantid,debit,request):
    try:
        userid = get_userid(request)
        credit = Credit_balance.objects.get(userid=userid,merchantid=merchantid)
        credit.credit_requested = float(credit.credit_requested) - float(debit)
        credit.save()
        return "Success"
    except Exception as e:
        print e
        return "Fail"

def aboutus(request):
    res = categories(request)
    suppliers = get_supplier(request)
    user_id = get_userid(request)
    cart = Cart.objects.filter(userid=user_id,status=0)
    # print credits
    if len(cart)>0:
        cart_data = get_cart(cart[0])
        data = {
            "res": res,
            "cart":cart_data,
            "suppliers":suppliers,
        }
    else:
        data = {
         "res":res,
         "suppliers":suppliers,
        }
    return render(request,'nogpo/aboutus.html',data)

@csrf_exempt
def checkuser(request):
    username = request.POST.get('username')
    print username
    users = User.objects.all()
    for user in users:
        if str(user.username) == username:
            return HttpResponse("username already present")
    return HttpResponse("success")
@csrf_exempt
def checkemail(request):
    email = request.POST.get('email')
    users = User.objects.all()
    for user in users:
        if str(user.email) == email:
            return HttpResponse("email already present")
    return HttpResponse("success")