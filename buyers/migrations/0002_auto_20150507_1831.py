# -*- coding: utf-8 -*-
from __future__ import unicode_literals

from django.db import models, migrations


class Migration(migrations.Migration):

    dependencies = [
        ('buyers', '0001_initial'),
    ]

    operations = [
        migrations.CreateModel(
            name='Cart_products',
            fields=[
                ('id', models.AutoField(verbose_name='ID', serialize=False, auto_created=True, primary_key=True)),
                ('product_id', models.CharField(max_length=70)),
                ('no_of_items', models.IntegerField()),
                ('status', models.IntegerField()),
                ('date', models.DateField()),
            ],
        ),
        migrations.RenameField(
            model_name='cart',
            old_name='no_of_items',
            new_name='status',
        ),
        migrations.RemoveField(
            model_name='cart',
            name='productid',
        ),
        migrations.AddField(
            model_name='cart',
            name='checkout_date',
            field=models.DateField(default=0),
            preserve_default=False,
        ),
        migrations.AddField(
            model_name='cart',
            name='total_price',
            field=models.DecimalField(default=0, max_digits=10, decimal_places=2),
            preserve_default=False,
        ),
        migrations.AddField(
            model_name='cart_products',
            name='cart_id',
            field=models.ForeignKey(to='buyers.Cart'),
        ),
    ]
