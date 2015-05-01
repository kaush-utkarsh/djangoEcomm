from django.conf.urls import patterns, include, url
from django.contrib import admin
from buyers import views

urlpatterns = patterns('',
    # Examples:
    # url(r'^$', 'nogpo.views.home', name='home'),
    # url(r'^blog/', include('blog.urls')),

    url(r'^admin/', include(admin.site.urls)),
    url(r'^accounts/', include('registration.urls')),
    url(r'^dashboard/', views.userdashboard, name="user_dashboard"),
    url(r'^$', views.home, name="home_page"),
    url(r'^products/$', views.products, name="products_page"),
    url(r'^prdetail/$', views.product_details, name="product_details"),
     url(r'^nogpo/', include('buyers.urls')),
)
