from django.shortcuts import render


def home(request):
    return render(request, "nogpo/home.html")

def products(request):
    return render(request, "nogpo/products.html")

def product_details(request):
    return  render(request, "nogpo/productdetails.html")

def userdashboard(request):
    user = request.user
    data = {}
    username = user.first_name + ' ' + user.last_name
    data['username'] = username
    data['email'] = user.email

    return  render(request, "nogpo/dashboard.html")