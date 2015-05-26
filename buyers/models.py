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
    no_of_items = models.IntegerField(max_length=360)
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
    Cleared_date = models.DateField()
    request_msg = models.TextField()
    response_msg = models.TextField()
    credit_expiry_date = models.DateField()

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