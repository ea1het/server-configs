# Notes on HAProxy with SSL Offloading using LetsEncrypt certificates

### How to create a self-signed certificate in one line
```
openssl req -new -newkey rsa:2048 -days 365 -nodes -x509 -keyout server.key -out server.crt
```


### How to request a LetsEncrypt certificate in one line
```
certbot certonly --standalone -d host.domain.tld --non-interactive --agree-tos --email me@domain.tld--http-01-port=8888
```


### How to enable a service in Alpine linux
```
rc-status
rc-update add '<your_service>' default
```

