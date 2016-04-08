from django.conf.urls import url
from buyers import views

urlpatterns = [
    url(r'^categories/',views.categories),
    url(r'^product/',views.product),
    url(r'^search/',views.search),
    # url(r'^edit_cart',views.edit_cart),
    # url(r'^delete_from_cart',views.delete_from_cart),
    url(r'^cart',views.cart),
]