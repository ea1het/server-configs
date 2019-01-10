#!/bin/ash 

###
#
# This scripts regenerates LetsEncrypt certificates
#
# 1. Place this file in /usr/local/bin
# 2. chmod u+x /usr/local/bin/update-certs.sh
#
###

# STEP 1: Renew the certificate
certbot renew --force-renewal --preferred-challenges http

# STEP 2: List certbot certificates
certbot certificates > /tmp/tmp.tmp

# STEP 3: Create a PEM file
for i in `grep "Name" /tmp/tmp.tmp  | awk -F ":" '{ print $2 }'`
do
  cat /etc/letsencrypt/live/$i/fullchain.pem /etc/letsencrypt/live/$i/privkey.pem > /etc/letsencrypt/live/$i/crtkey.pem
  echo $i
done

# STEP 4: Clean-up
rm -f /tmp/tmp.tmp

# STEP 5: Restart service
/etc/init.d/haproxy restart
