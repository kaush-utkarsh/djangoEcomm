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
    url(r'^checkout/',views.checkout),
    url(r'^credits/',views.credits),
    url(r'^nogpo/', include('buyers.urls')),
    url(r'^userproduct/delete/',views.delete_from_cart),
    url(r'^emptycart/', views.empty_cart),
    url(r'^suppliers/get/',views.get_supplier),
    url(r'^usermeta/',views.meta),
    url(r'^hospitals/',views.hospital),
    url(r'^best-sellers/',views.best_sellers),
    url(r'^new-products/',views.new_products),
    url(r'^top-rated/',views.top_rated),
    url(r'^purchased/',views.purchase),
    url(r'^contact/',views.contact),
    url(r'^thanks/',views.thanks),
    url(r'^seller_credit_payment/',views.seller_credit_payment),
    url(r'^subcategory/',views.subcategory),
    url(r'^related_product/',views.related_products),

)
