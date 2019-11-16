# OpenVPN for Mikrotik
The following is the guide to configure, step by step, an OpenVPN server (with its clients) on a Mikrotik device. 

## Certificate creation stage **(on the Mikrotik)**
The first step is to generate certificates, and sign them, for an internal CA, for the OpenVPN server and for one (or many) clients. Steps follow:

### CA certificate
``` 
/certificate add name=CA country="ES" state="AS" locality="ASTURIAS" organization="ACME" \
unit="DevSecOps" common-name="CA" key-size=4096 days-valid=3650 \ 
key-usage=crl-sign,key-cert-sign

/certificate sign CA ca-crl-host=127.0.0.1 name="CA"
``` 
### Server certificate
``` 
/certificate add name=server country="ES" state="AS" locality="ASTURIAS" organization="ACME" \
unit="DevSecOps" common-name="server" key-size=4096 days-valid=3650 \
key-usage=digital-signature,key-encipherment,tls-server

/certificate sign server ca="CA" name="server"
``` 
### Client certificate(s)
```
/certificate add name=client1 country="ES" state="AS" locality="ASTURIAS" organization="ACME" \
unit="DevSecOps" common-name="client1" key-size=4096 days-valid=3650 key-usage=tls-client

/certificate sign client1 ca="CA" name="client1"
``` 

Steps to reproduce for many clients are essentially the same:
```
/certificate add name=client2 copy-from="client1" common-name="client2"

/certificate sign client2 ca="CA" name="client2"
``` 

### Certificate export
Finally, the certificates generated are exported in the Mikrotik device, being stored in "/File" on the Mikrotik flash:

``` 
/certificate export-certificate CA export-passphrase=""

/certificate export-certificate client1 export-passphrase="password"

/certificate export-certificate client2 export-passphrase="password"
``` 


## Server configuration stage **(on the Mikrotik)**

### IP Pool and DHCP server configurtation
```
/ip pool add name=ovpn ranges=172.16.30.2-172.16.30.10

/ip dhcp-server network add address=172.16.30.0/24 comment=vpn dns-server=172.16.30.1 \
gateway=172.16.30.1 netmask=24
```

### PPP profile for OpenVPN
```
/ppp profile add dns-server=172.16.30.1 local-address=ovpn name=open_vpn remote-address=ovpn \
use-compression=no use-encryption=required
```

### OpenVPN server configuration
``` 
/interface ovpn-server server 

set certificate=server port=1194 cipher=blowfish128,aes128,aes192,aes256 \
default-profile=open_vpn enabled=yes require-client-certificate=yes
```

## Client configuration stage **(on the Mikrotik)**
```
/ppp secret add name=client1 password=password profile=open_vpn service=ovpn
```

As we have created two client certificates in the initial steps, we reproduce the above command again for the second client certificate. You can reproduce ths two steps as many times as OpenVPN clients you have. 
```
/ppp secret add name=client2 password=password profile=open_vpn service=ovpn
```

## Routing & Firewall configuration stage (on the Mikrotik)
``` 
/ip firewall nat add chain=srcnat src-address=172.16.30.0/24 action=masquerade 

/ip firewall filter add action=accept chain=input comment=VPN dst-port=1194 protocol=tcp
```


## Certificate handling **(on the local PC/macOS/Linux)**
Depending on your operating system, you will need OpenSSL (or similar package) to complete next sterps. Guidance on how to install OpenSSL is out of scope of this how-to.

Certificates used on Mikrotik are generated with password (in order to enable key exportation) but later on will be never used (configuration is done for certificate exchange, not shared secret). You must issue following commands in your local machine on a Terminal window:

### Password removal from client keys
For simplicity, only client1 will be illustrated. Nonetheless, this exact command can be used (or will be needed) for all the other client certificates. 
```
openssl rsa -passin pass:password -in cert_export_client1.key -out client1.key
```

Once done, you can delete the old key files:
```
rm -f cert_export_*.key
```

Finally, and for easyness, we'll change certificate names:
```
mv cert_export_client1.crt client1.crt
```

And here the CA name:
```
mv cert_export_CA.crt CA.crt
```

## OpenVPN client configuration
Once you have completed all the above step you will have a fully functional OpenVPN server in your Mikrotik device. Now you need to configure a clien device (laptop, tablet or mobile phone) witha client configuration. Use the following for simplicity:

```
#####################################################################
#
# OPENVPN CLIENT CONFIGURATION FILE 
#
#####################################################################

client
dev tun
proto tcp
remote vpn.remotesite.tld 1194
nobind
persist-key
persist-tun
verb 2
pull
reneg-sec 0
key-direction 1
cipher AES-256-CBC
auth SHA1
auth-retry none
auth-nocache
resolv-retry infinite
# remote-cert-tls server
# tls-client

# CERTIFICATE DATA
auth-user-pass user.auth


#####################################################################
##
## CLIENT CERTIFICATES IN-LINE MODE
##
#####################################################################

## HERE COMES THE CA CERTIFICATE
<ca>
...
</ca>

<cert>
...
</cert>

<key>
...
</key>

```


_END_
