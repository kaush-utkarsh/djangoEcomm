from .models import Cart,Cart_products,Subcart,Credit_balance,Transaction,Payment
import urllib2
import json

baseurl = 'http://162.209.8.12:8080/'

def get_supplier(request):
    if request.method == 'GET':
        url = baseurl + 'supplier'
        response = urllib2.urlopen(url)
        return json.load(response)

def current_credit(userid,request):
    supplier_list = get_supplier(request)
    credit_list = []
    credit_balances = Credit_balance.objects.filter(userid=userid)
    # print credit_balances
    if len(credit_balances) > 0:
        for credit_balance in credit_balances:
            supplier_name = getname(supplier_list,credit_balance.merchantid)
            credit = {
                'supplier_name':getname(supplier_list,credit_balance.merchantid),
                'supplierid':credit_balance.merchantid,
                'credit_requested':credit_balance.credit_requested,
                'credit_approved':credit_balance.credit_approved,
                'credit_expiry_date':credit_balance.credit_expiry_date
            }
            credit_list.append(credit)
            print "---------------------------------------------"
            print supplier_name
            print credit_balance.merchantid
    else:
        credit = {
            'supplier_name':'No Name',
            'supplierid':'No Supplier',
            'credit_requested':'No credit requested',
            'credit_approved': 'No credit approved',
            'credit_expiry_date':'No credit'
        }
        credit_list.append(credit)
    return credit_list

def getname(suppliers,supplierid):
    for supplier in suppliers:
        if int(supplier['id']) == int(supplierid):
            return supplier['name']

    return 'Local Dealer'