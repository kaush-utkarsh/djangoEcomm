from django.db import models

# Create your models here.
class Cart(models.Model):
    userid = models.CharField(max_length=200)
    status = models.IntegerField()
    checkout_date = models.DateField()
    total_price = models.DecimalField(max_digits=10,decimal_places=2)

class Subcart(models.Model):
    supplierid = models.CharField(max_length=200)
    cart_id = models.ForeignKey(Cart)
    total_price = models.DecimalField(max_digits=10,decimal_places=2)
    status = models.IntegerField()


class Cart_products(models.Model):
    subcart_id = models.ForeignKey(Subcart)
    product_id = models.CharField(max_length=70)
    no_of_items = models.IntegerField(max_length=360,default=0)
    price = models.DecimalField(max_digits=10,decimal_places=2)
    status = models.IntegerField(default=1)
    date = models.DateTimeField(max_length=132)


class Credit_balance(models.Model):
    userid = models.CharField(max_length=200)
    merchantid = models.CharField(max_length=200)
    credit_requested = models.DecimalField(max_digits=10,decimal_places=2)
    credit_approved = models.DecimalField(max_digits=10,decimal_places=2)
    credit_status = models.IntegerField()
    applied_date = models.DateField()
    Cleared_date = models.DateField(null=True, blank=True)
    request_msg = models.TextField()
    response_msg = models.TextField()
    credit_expiry_date = models.DateField(null=True, blank=True)


class Transaction(models.Model):
    cart_id = models.ForeignKey(Cart)
    status = models.IntegerField()

class Payment(models.Model):
    payment_id = models.IntegerField()
    method = models.CharField(max_length=50)
    ammount = models.DecimalField(max_digits=10,decimal_places=2)
    transaction_id = models.ForeignKey(Transaction)
    msg = models.TextField()
    method_id = models.CharField(max_length=200)
    subcart_id = models.ForeignKey(Subcart)

class User_meta(models.Model):
    userid = models.CharField(max_length=200)
    metakey = models.TextField()
    metavalue = models.TextField()

class Hospitals(models.Model):
    mongoid = models.CharField(max_length=253,null=True,blank=True)
    name = models.CharField(max_length=63)
    address = models.CharField(max_length=254,null=True,blank=True)
    city = models.CharField(max_length=63,null=True,blank=True)
    state = models.CharField(max_length=16,null=True,blank=True)
    zip = models.BigIntegerField(null=True,blank=True)
    website = models.CharField(max_length=63,null=True,blank=True)
    phone = models.BigIntegerField(null=True,blank=True)
    description = models.TextField()
    specialty = models.CharField(max_length=63,null=True,blank=True)
    revenue = models.CharField(max_length=63,null=True,blank=True)
    contacts = models.TextField()
    class Meta:
        db_table = 'hospitals'

class Ecommerce_user_hospital_link(models.Model):
    user_id = models.IntegerField()
    hospital_id = models.IntegerField()
    # status = models.IntegerField(default=0)
    class Meta:
        db_table = 'ecommerce_user_hospital_link'