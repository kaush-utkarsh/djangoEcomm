from .models import Cart,Cart_products,Subcart,Credit_balance,Transaction,Payment


def current_credit(userid):
    supplier_list = []
    credit_list = []
    credit_balances = Credit_balance.objects.filter(userid=userid)
    # print credit_balances
    if len(credit_balances) > 0:
        for credit_balance in credit_balances:
            credit = {
                'supplierid':credit_balance.merchantid,
                'credit_requested':credit_balance.credit_requested,
                'credit_approved':credit_balance.credit_approved,
                'credit_expiry_date':credit_balance.credit_expiry_date
            }
            credit_list.append(credit)
    else:
        credit = {
            'supplierid':'No Supplier',
            'credit_requested':'No credit requested',
            'credit_approved': 'No credit approved',
            'credit_expiry_date':'No credit'
        }
        credit_list.append(credit)
    return credit_list