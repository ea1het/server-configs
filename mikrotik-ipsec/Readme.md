## IPSec Configuration for a Site-to-Site tunnel

Once applied the below script in your Mikrotik box __ensure the Firewall>Filter and the Firewall>NAT rules are placed at the very top of the list__. Otherwise, tunnel might fail to establish.

```  
/ip ipsec profile set [ find default=yes ] dh-group=modp2048 enc-algorithm=aes-256 lifetime=30m
/ip ipsec profile add dh-group=modp2048 enc-algorithm=aes-256 lifetime=30m name=ipsec-site2site

/ip ipsec proposal set [ find default=yes ] enc-algorithms=aes-256-cbc pfs-group=modp2048
/ip ipsec proposal add enc-algorithms=aes-256-cbc name=ipsec-site2site pfs-group=modp2048

/ip ipsec peer add address=REMOTE.PUBLIC.IP.HERE local-address=LOCAL.PUBLIC.IP.HERE name=PEER.NAME.HERE profile=ipsec-site2site

/ip ipsec identity add comment="IPSec Site-to-Site" peer=PEER.NAME.HERE secret=PUT.HERE.YOUR.SUPER.DIFFCULT.SECRET

/ip ipsec policy add dst-address=REMOTE.CIDR-RANGE.HERE peer=PEER.NAME.HERE proposal=ipsec-site2site sa-dst-address=REMOTE.PUBLIC.IP.HERE sa-src-address=LOCAL.PUBLIC.IP.HERE src-address=LOCAL.CIDR-RANGE.HERE tunnel=yes

/ip firewall filter add action=accept chain=forward dst-address=LOCAL.CIDR-RANGE.HERE src-address=REMOTE.CIDR-RANGE.HERE
/ip firewall filter add action=accept chain=forward dst-address=REMOTE.CIDR-RANGE.HERE src-address=LOCAL.CIDR-RANGE.HERE

/ip firewall nat add action=accept chain=srcnat comment="IPSec Site-to-Site" dst-address=REMOTE.CIDR-RANGE.HERE src-address=LOCAL.CIDR-RANGE.HERE

/system scheduler add comment="Comprobaci\F3n de IPs en las SAs de IPSec" interval=10m name=Tunel_IPSec on-event=Tunnel_IPSec policy=ftp,reboot,read,write,policy,test,password,sniff,sensitive,romon start-time=startup

/system script add dont-require-permissions=no name=Tunnel_IPSec owner=admin policy=ftp,reboot,read,write,policy,test,password,sniff,sensitive,romon source=":log info \"Comprobacion IPSEC\"\r\
    \n#\r\
    \n# Variables necesarias \r\
    \n#\r\
    \n:global RemoteIP [:resolve REMOTE.DNS.TLD]\r\
    \n:global LocalIP [:resolve LOCAL.DNS.TLD]\r\
    \n#\r\
    \n# Obtener valores actuales de las IPs en uso\r\
    \n#\r\
    \n:global actualRemote [/ip ipsec peer get PEER.NAME.HERE address]\r\
    \n:global actualRemote [:pick \$actualRemote 0 [:find \$actualRemote \"/\"]]\r\
    \n:global actualLocal [/ip ipsec peer get PEER.NAME.HERE local-address]\r\
    \n:delay 1s\r\
    \n#\r\
    \n# Cambiar la politica si la IP remota ha cambiado\r\
    \n#\r\
    \n:if (\$RemoteIP !=\$actualRemote)  do={\r\
    \n:log info \"Comprobando IP remota: IP actualizada. Nueva IP es \$RemoteIp\"\r\
    \n/ip ipsec peer set PEER.NAME.HERE address=\$RemoteIP local-address=\$LocalIP\r\
    \n} else= {\r\
    \n:log info \"No hay cambios\"\r\
    \n}\r\
    \n:delay 1s\r\
    \n#\r\
    \n# Cambiar la politica si la IP local ha cambiado\r\
    \n#\r\
    \n:if (\$LocalIP !=\$actualLocal) do={\r\
    \n:log info \"Comprobando la IP local: IP actualizada. Nueva IP es \$LocalIp\"\r\
    \n/ip ipsec peer set PEER.NAME.HERE address=\$RemoteIP local-address=\$LocalIP\r\
    \n} else= {\r\
    \n:log info \"No hay cambios\"\r\
    \n}\r\
    \n"

```   

