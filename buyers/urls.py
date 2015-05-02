from django.conf.urls import url
from buyers import views

urlpatterns = [
    url(r'^categories/',views.categories),
    url(r'^product/',views.product),
    url(r'^search/',views.search)
]