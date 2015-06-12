from .models import Cart,Cart_products,Subcart,Credit_balance,Transaction,Payment,User_meta
from django.contrib.sessions.models import Session
import json
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
        metakey = request.POST.get('metakey','')
        metavalue = request.POST.get('metavalue','')
        metavalue = json.loads(str(metavalue))
        metavalue=create_dict(metavalue)
        userid = get_userid(request)
        try:
            user_meta = User_meta.objects.get(userid=userid,metakey=metakey)
            user_meta.metavalue = metavalue
        except User_meta.DoesNotExist:
            user_meta = User_meta(userid=userid,metakey=metakey,metavalue=metavalue)
        user_meta.save()
        return "success"

def create_dict(metavalue):
    metadict = {}
    for meta in metavalue:
        metadict[meta['name']] = meta['value']

    return metadict