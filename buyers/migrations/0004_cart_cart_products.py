# -*- coding: utf-8 -*-
from __future__ import unicode_literals

from django.db import models, migrations


class Migration(migrations.Migration):

    dependencies = [
        ('buyers', '0003_auto_20150507_1833'),
    ]

    operations = [
        migrations.CreateModel(
            name='Cart',
            fields=[
                ('id', models.AutoField(verbose_name='ID', serialize=False, auto_created=True, primary_key=True)),
                ('userid', models.CharField(max_length=200)),
                ('status', models.IntegerField()),
                ('checkout_date', models.DateField()),
                ('total_price', models.DecimalField(max_digits=10, decimal_places=2)),
            ],
        ),
        migrations.CreateModel(
            name='Cart_products',
            fields=[
                ('id', models.AutoField(verbose_name='ID', serialize=False, auto_created=True, primary_key=True)),
                ('product_id', models.CharField(max_length=70)),
                ('no_of_items', models.IntegerField()),
                ('status', models.IntegerField()),
                ('date', models.DateField()),
                ('cart_id', models.ForeignKey(to='buyers.Cart')),
            ],
        ),
    ]
