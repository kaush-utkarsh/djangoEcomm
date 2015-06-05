from .models import Cart,Cart_products,Subcart,Credit_balance,Transaction,Payment


def current_credit(userid):
    supplier_list = []
    credit_list = []
    credit_balances = Credit_balance.objects.filter(userid=userid)
    print credit_balances
    for credit_balance in credit_balances:
        credit = {
            'supplierid':credit_balance.merchantid,
            'credit_approved':credit_balance.credit_approved,
            'credit_expiry_date':credit_balance.credit_expiry_date
        }
        credit_list.append(credit)
    print credit_list
    return credit_list