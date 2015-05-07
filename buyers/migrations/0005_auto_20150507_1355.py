# -*- coding: utf-8 -*-
from __future__ import unicode_literals

from django.db import models, migrations


class Migration(migrations.Migration):

    dependencies = [
        ('buyers', '0004_cart_cart_products'),
    ]

    operations = [
        migrations.AlterField(
            model_name='cart_products',
            name='date',
            field=models.DateTimeField(),
        ),
    ]
