#!/bin/sh
/var/www/lms/scripts/alior2lms_new_fibermax.py > /var/www/lms/logi/alior-$(date +%Y%m%d%H%M%S).log 2>&1
