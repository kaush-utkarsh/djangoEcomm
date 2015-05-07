# -*- coding: utf-8 -*-
from __future__ import unicode_literals

from django.db import models, migrations


class Migration(migrations.Migration):

    dependencies = [
        ('buyers', '0002_auto_20150507_1831'),
    ]

    operations = [
        migrations.RemoveField(
            model_name='cart_products',
            name='cart_id',
        ),
        migrations.DeleteModel(
            name='Cart',
        ),
        migrations.DeleteModel(
            name='Cart_products',
        ),
    ]
