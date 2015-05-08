# -*- coding: utf-8 -*-
from __future__ import unicode_literals

from django.db import models, migrations


class Migration(migrations.Migration):

    dependencies = [
        ('buyers', '0005_auto_20150507_1355'),
    ]

    operations = [
        migrations.AlterField(
            model_name='cart_products',
            name='date',
            field=models.DateTimeField(max_length=132),
        ),
        migrations.AlterField(
            model_name='cart_products',
            name='no_of_items',
            field=models.IntegerField(max_length=360),
        ),
        migrations.AlterField(
            model_name='cart_products',
            name='status',
            field=models.IntegerField(default=1),
        ),
    ]
