from django.db import models

# Create your models here.
class Cart(models.Model):
    userid = models.CharField(max_length=200)
    productid = models.CharField(max_length=70)
    no_of_items = models.IntegerField()

    def __unicode__():
        return self.id