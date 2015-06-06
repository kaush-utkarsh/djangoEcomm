from .models import Cart,Cart_products,Subcart,Credit_balance,Transaction,Payment,User_meta
from django.contrib.sessions.models import Session

def get_userid(request):
    session = Session.objects.get(session_key=request.session._session_key)
    session_data = session.get_decoded()
    uid = session_data.get('_auth_user_id')
    return uid

def user_meta_data(request):
    if request.method == "GET":
        userid = get_userid(request)
        metakey = request.GET.get('metakey','')
        user_meta = User_meta.objects.get(userid=userid,metakey=metakey)
        meta = {
            'metakey':user_meta.metakey,
            'metavalue':user_meta.metavalue
        }
        return meta
    if request.method == "POST":
        # data = request.POST
        metakey = request.POST.get('metakey','')
        metavalue = request.POST.get('metavalue','')
        # print data
        userid = get_userid(request)
        user_meta = User_meta(userid=userid,metakey=metakey,metavalue=metavalue)
        user_meta.save()
        return "success"