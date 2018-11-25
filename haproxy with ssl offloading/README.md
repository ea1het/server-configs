# Notes on HAProxy with SSL Offloading using LetsEncrypt certificates

### How to create a self-signed certificate in one line
```
openssl req -new -newkey rsa:2048 -days 365 -nodes -x509 -keyout server.key -out server.crt
```


### How to request a LetsEncrypt certificate in one line
```
certbot certonly --standalone -d host.domain.tld --non-interactive --agree-tos --email me@domain.tld --http-01-port=8888
```

### How to craft a PEM file valid for HAProxy per domain using SSL/TLS offloading
i) Enter the Letsencrypt "live" directory, typically /etc/letsencrypt/live
ii) Enter the folder for the correct domain name, say domain.tld
```
cd /etc/letsencrypt/live
cd domain.tld
```
iii) Now craft a new PEM file with the contents of fulchain.pem and privkey.pem
```
cat fullchain.pem privkey.pem > crtkey.pem
```
iv) Add a line in /etc/haproxy/crt-list.txt to the newly generated PEM file

### How to enable a service in Alpine linux
```
rc-status
rc-update add '<your_service>' default
```

