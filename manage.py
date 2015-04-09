#!/usr/bin/env python
import os
import sys

if __name__ == "__main__":
<<<<<<< HEAD
    os.environ.setdefault("DJANGO_SETTINGS_MODULE", "nogpo.settings")
=======
    os.environ.setdefault("DJANGO_SETTINGS_MODULE", "nogpo_ecommerce.settings")
>>>>>>> e851fdc458cdc922de5550cc9e4e389c0761e76c

    from django.core.management import execute_from_command_line

    execute_from_command_line(sys.argv)
