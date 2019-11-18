# Mikrotik Port-Knocking


## Resume
Port knocking is a method of establishing a connection to a networked device that has no open ports or they are filtered.

Before a connection is established, a combination of ports are opened using a knocking sequence, which in essence is a series of connection attempts to closed but supervised ports.

A remote host (i.e., a remote client machine) generates a knock sequence in order to tell the firewall it's awaiting to enter the protected network. The firewall will supervise the knock sequence. If the sequence is correct, the firewall exposes only to that remote client machine the expected real destionation ports, i.e., SSH or VPN ones. 

Closure of the previously enabled ports happen by TCP/IP TTL. Closure of wrongly opened ports ona erroneus port-knocking sequence happen after 15s.


## Configuration details
In the following example, port __22/TCP__ will be opened if the port-knocking combination __51000/UDP -> 52000/UDP -> 53000/UDP__ is executed successfully by a remote client machine. 

```  
/ip firewall filter
 
add action=log chain=input log-prefix="Port-Knocking Stage 1" disabled=no\
    protocol=udp dst-port=51000

add action=add-src-to-address-list address-list="Knock-1"\
    address-list-timeout=15s chain=input disabled=no\
    dst-port=51000 protocol=udp
 
add action=log chain=input log-prefix="Port-Knocking Stage 2" disabled=no\
    protocol=udp dst-port=52000 src-address-list="Knock-1"

add action=add-src-to-address-list address-list="Knock-2"\
    address-list-timeout=15s chain=input disabled=no\
    dst-port=52000 protocol=udp
 
add action=log chain=input log-prefix="Port-Knocking Stage 3" disabled=no\
    protocol=udp dst-port=53000 src-address-list="Knock-2"

add action=add-src-to-address-list address-list="Knock-3"\
    address-list-timeout=15s chain=input disabled=no\
    dst-port=53000 protocol=udp
 
add action=accept chain=input disabled=no\
    dst-port=22 protocol=tcp src-address-list="Knock-3"
```  
