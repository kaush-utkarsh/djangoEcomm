from django.db import models

# Create your models here.
class Cart(models.Model):
    userid = models.CharField(max_length=200)
    status = models.IntegerField()
    checkout_date = models.DateField()
    total_price = models.DecimalField(max_digits=10,decimal_places=2)


class Cart_products(models.Model):
    cart_id = models.ForeignKey(Cart)
    product_id = models.CharField(max_length=70)
    no_of_items = models.IntegerField(max_length=360)
    status = models.IntegerField(default=1)
    date = models.DateTimeField(max_length=132)

    def __str__(self):
        return self.cart_id

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
    # rejection_date = models.DateField()
    # status = models.IntegerField()
