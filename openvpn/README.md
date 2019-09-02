# Configuration bits

### Enable IP Forwarding in SysCtl




### Configuration in IPTables

Configure IP Forwarding

    Option 1: Edit /etc/sysctl.conf and enable IP Forwarding by adding the following directive:
        net.ipv4.ip_forward = 1
        Then, at system prompt, type “# sysctl –p” to persist changes

    Option 2: Write /proc directly
        echo 1 > /proc/sys/net/ipv4/ip_forward
        Then, at system prompt, type “# sysctl –p” to persist changes

    Option 3: Write sysctl directly from console:
    # sysctl –p net.ipv4.ip_forward 1



## IF USING UFW:
### First step is to configure the ufw rules
This is done using the following ufw commands in the console:
```
ufw allow out on tun0
ufw allow out on eth0

ufw limit 1194/udp comment 'Rate limit for OpenVPN'
ufw limit from <Your_Home_IP> to any port 22/tcp comment 'Rate limit for OpenSSH server'
ufw allow in on tun0 to any port 22/tcp comment 'OpenSSH within VPN'
``` 

### Final step is to configure /etc/ufw/before.rules for NAT masquerading support
Add the following text at the begining of the mentioned file:
```
############################################################
# START OPENVPN RULES
# NAT table rules

*nat
:POSTROUTING ACCEPT [0:0]
# Allow traffic from OpenVPN client to eth0
-A POSTROUTING -s 10.255.255.0/24 -o eth0 -j MASQUERADE
COMMIT

# END OPENVPN RULES
############################################################
```



## IF USING IPTABLES: Save Firewall Rules For iptables

- Configure overloading/masquerading
    ```
    iptables -t nat -A POSTROUTING -s 10.255.255.0/24 -o eth0 -j MASQUERADE
    ```

-  Write the firewall rules to disk
    ```
    /etc/init.d/iptables save
    ```
    
-  Set iptables to start on reboot
    ```
    rc-update add iptables 
    ```
