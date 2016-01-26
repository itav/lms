#!/usr/bin/python
import os, imaplib, email, re, smtplib, sys, datetime
from cStringIO import StringIO
old_stdout = sys.stdout
sys.stdout = to_mail = StringIO()
#Z JAKICH EMAILI MOGA POCHODZIC WYCIAGI
allowed = ['powiadomienia@alior.pl', 'mirek@netella.net']
def sizeof_fmt(num):
	for x in ['b','KB','MB','GB']:
		if num < 1024.0 and num > -1024.0:
			return "%3.1f%s" % (num, x)
		num /= 1024.0
	return "%3.1f%s" % (num, 'TB')
#SERWER IMAP
connection = imaplib.IMAP4_SSL("imap.gmail.com")
#DANE DO LOGOWANIA IMAP login, haslo
connection.login("alior@optomedia.pl","123optomedia3")
connection.select('INBOX')
(retcode, messages) = connection.search(None, '(UNSEEN)')
if retcode == 'OK':
	for msgid in messages[0].split():
		mretcode, data = connection.fetch(msgid,'(BODY.PEEK[])')
		if mretcode == "OK":
			mail = email.message_from_string(data[0][1])
			if mail['From'].split("<")[1].replace(">","") in allowed:
				print "Przetwarzam e-mail [%s @ %s]:" % (mail['From'], mail['Delivery-date'])
				for part in mail.walk():
					if part.get_content_maintype() == 'multipart':
						continue
					if part.get('Content-Disposition') is None:
						continue
					filename = part.get_filename()
					if ".7z" in filename:
						print " * "+filename+"...",
						filepath = os.path.join('/var/www/lms/data/', 'alior2lms_nowy', filename)
						print "Zapisuje %s..." % filepath,
						if not os.path.isfile(filepath) :
							fh = open(filepath, 'wb')
       		             				fh.write(part.get_payload(decode=True))
	       	             				fh.close()
							print "Zapis ok!...",
						else:
							print "Plik istnieje, nie nadpisuje!...",
						print sizeof_fmt(os.path.getsize(filepath))
			connection.copy(msgid, 'INBOX.Archiwum')
			connection.store(msgid, '+FLAGS', '\\Deleted')
	connection.expunge()
sys.stdout = old_stdout
to_mail=to_mail.getvalue()
#if to_mail!="":
#	smtp=smtplib.SMTP()
#	#RAPORTOWANIE adres SMTP
#	smtp.connect("optomedia.pl", 587)
#	#LOGIN I HASLO DO SKRZYNKI
#	smtp.login("alior@optomedia.pl","123optomedia3")
#	from_addr="alior@optomedia.pl>"
#	#DO KOGO MA BYC WYSYLANY EMAIL Z RAPORTEM
#	to_addr="mirek@netella.pl"
#	subj="Raport z importu do archiwum [ALIOR]"
#	date = datetime.datetime.now().strftime( "%d/%m/%Y %H:%M" )
#	msg = "From: %s\nTo: %s\nSubject: %s\nDate: %s\n\n%s" % (from_addr, to_addr, subj, date, to_mail)
#	smtp.sendmail(from_addr, to_addr, msg)
#	smtp.quit()
