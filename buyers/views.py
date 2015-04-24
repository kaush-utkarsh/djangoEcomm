from django.shortcuts import render


def home(request):
    return render(request, "nogpo/home.html")

def products(request):
    return render(request, "nogpo/products.html")

def product_details(request):
    return  render(request, "nogpo/productdetails.html")