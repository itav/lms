#!/usr/bin/python -u
# -*- coding: utf-8 -*-

#KATALOG Z PLIKAMI 
katalog="/var/www/lms/data/alior2lms_nowy/"
#HASLO DO DEKODOWANIA WYCIAGOW
haslo="LDwl&mzt2" # !!!!!!!! zmienna nieuzywana, wpisane recznei do linijki rozpakowywujacej plik

import random, pickle, os, codecs, shutil, oursql
from decimal import Decimal
#POLACZENIE Z BAZA SQL
con=oursql.connect(host="localhost", user="lms", passwd="zaq1@WSXasd321", db="lms")
c=con.cursor(oursql.DictCursor)
print "Wczytuje liste przetworzonych wyciagow...",
try:
	przetworzone = pickle.load(open("/var/www/lms/data/alior.db", "rb"))
except IOError:
	przetworzone = []
sql = []
print len(przetworzone),"wczytano"
katalog_plikow = []
print "Sprawdzam liste plikow w folderze...",
for plik in os.listdir(katalog):
	if plik[-3:]==".7z":
		katalog_plikow.append(plik)
print len(katalog_plikow),"plikow"
do_przetworzenia = []
print "Sprawdzam, ktore pliki nie zostaly przetworzone...",
for plik in katalog_plikow:
	if plik not in przetworzone:
		do_przetworzenia.append(plik)
print len(do_przetworzenia), "plikow\n"
for plik in do_przetworzenia:
	katalog_e = "/tmp/rpt-%x" % random.getrandbits(64)
	print "Przetwarzanie pliku %s, katalog %s..." % (plik, katalog_e),
	os.mkdir(katalog_e)
	print "Katalog stworzony...",
	os.popen("/usr/bin/7z -o%s -p'LDwl&mzt2' e %s" % (katalog_e, katalog+plik))
	print "Plik rozpakowany..."
	total = Decimal(0)
	fid = os.listdir(katalog_e)[0].replace(".rpt","")[-4:]
	for wpis in codecs.open(katalog_e+"/"+os.listdir(katalog_e)[0], mode="rb", encoding="ascii", errors="ignore").readlines():
		wpis = wpis.rstrip().replace('"','').split(",")
		if wpis[0]=="2":
			date = wpis[1]
			id = int(wpis[2].split("70000120")[1])
			amount = (Decimal(wpis[4])/100).quantize(Decimal("0.00"))
			total+=amount
			desc = " ".join(wpis[7:]).replace("'","")
			print "   ID: %s Data: %s Kwota: %s Opis: %s [%s]" % (id, date, amount, desc, os.listdir(katalog_e)[0])
			sql.append("insert into cashimport (date, value, customer, description, customerid, hash) values ( UNIX_TIMESTAMP(DATE('%s')), %s, (SELECT concat(customers.name,' ', customers.lastname) as cid from customers where id=%s), '%s-%s', %s, md5('%s%s%s%s') );" % (date, amount, id, desc, fid, id, desc, id, amount, fid))
	przetworzone.append(plik)
	print "\nRazem zaksiegowano %szl z pliku %s. " % (total, os.listdir(katalog_e)[0]),
	shutil.rmtree(katalog_e)
	print "Usunieto katalog tymczasowy %s...\n" % katalog_e
print "Dodaje %s wpisow SQL do bazy" % len(sql)
for command in sql:
	c.execute(command)
print "Zapisuje informacje o przetworzonych plikach..."
pickle.dump(przetworzone,open("/var/www/lms/data/alior.db","wb"))
