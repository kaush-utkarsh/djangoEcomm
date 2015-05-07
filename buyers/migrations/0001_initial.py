# -*- coding: utf-8 -*-
from __future__ import unicode_literals

from django.db import models, migrations


class Migration(migrations.Migration):

    dependencies = [
    ]

    operations = [
        migrations.CreateModel(
            name='Cart',
            fields=[
                ('id', models.AutoField(verbose_name='ID', serialize=False, auto_created=True, primary_key=True)),
                ('userid', models.CharField(max_length=200)),
                ('productid', models.CharField(max_length=70)),
                ('no_of_items', models.IntegerField()),
            ],
            options={
            },
            bases=(models.Model,),
        ),
    ]
