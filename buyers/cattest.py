import urllib2
import json

def categories():
	d = {"pcategor":[]}
	req = urllib2.urlopen("http://162.209.8.12:8080/nogpo/categories")
	res = json.load(req)
	l = len(res)
	for i in range(l):
		if res[i]["parent"] == 1:
			d["pcategor"].append(res[i]["name"])
	print d