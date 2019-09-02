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


## IF USING IPTABLES: Save Firewall Rules For iptables

- Configure overloading/masquerading
    ```
    iptables -t nat -A POSTROUTING -s 10.0.0.0/16 -o eth0 -j MASQUERADE
    ```

-  Write the firewall rules to disk
    ```
    /etc/init.d/iptables save
    ```
    
-  Set iptables to start on reboot
    ```
    rc-update add iptables 
    ```


## IF USING UFW:
```
ufw limit udp 1194 0.0.0.0/0 any 0.0.0.0/0 in 
ufw limit tcp 22 0.0.0.0/0 any <your_house_IP>

ufw allow any any 0.0.0.0/0 any 0.0.0.0/0 out_tun0
ufw allow any any 0.0.0.0/0 any 0.0.0.0/0 out_eth0
ufw allow tcp 22 0.0.0.0/0 any 0.0.0.0/0 in_tun0 
``` 

