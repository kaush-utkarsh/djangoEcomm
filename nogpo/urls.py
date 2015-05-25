from django.conf.urls import patterns, include, url
from django.contrib import admin

from buyers import urls, views


urlpatterns = patterns('',
    # Examples:
    # url(r'^$', 'nogpo.views.home', name='home'),
    # url(r'^blog/', include('blog.urls')),

    url(r'^admin/', include(admin.site.urls)),
    url(r'^accounts/', include('registration.urls')),
    url(r'^$', views.home, name="home_page"),
    url(r'^product/([\w]+)',views.product),
    url(r'^products/$', views.products, name="products_page"),
    url(r'^prdetail/$', views.products_details, name="products_details"),
    url(r'^add_to_cart/',views.add_to_cart),
    url(r'^cart/',views.cart),
    url(r'^nogpo/', include('buyers.urls')),
    url(r'^userproduct/delete/',views.delete_from_cart),
    url(r'^emptycart/'views.empty_cart)
)
