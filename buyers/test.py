import requests

a=requests.get('http://162.209.8.12:8080/categories')
print a.json()