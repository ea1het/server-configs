# Mikrotik blacklist

The following is a modified excerpt of what was proposed by Joshaven Potter in his website, http://joshaven.com/resources/tricks/mikrotik-automatically-updated-address-list/

## SpamHaus
``` 
# Script which will download the drop list as a text file
/system script add name="Download_Spamhaus" source={
/tool fetch url="http://joshaven.com/spamhaus.rsc" mode=http dst-path=disk1/spamhaus.rsc;
:log info "Downloaded spamhaus.rsc from Joshaven.com";
}

# Script which will Remove old Spamhaus list and add new one
/system script add name="Replace_Spamhaus" source={
/ip firewall address-list remove [find where comment="SpamHaus"]
/import file-name=disk1/spamhaus.rsc;
:log info "Removed old Spamhaus records and imported new list";
}

# Schedule the download and application of the spamhaus list
/system scheduler add comment="Download spamhaus list" interval=3d \
  name="DownloadSpamhausList" on-event=Download_Spamhaus \
  start-date=jan/01/1970 start-time=00:30:00
/system scheduler add comment="Apply spamhaus List" interval=3d \
  name="InstallSpamhausList" on-event=Replace_Spamhaus \
  start-date=jan/01/1970 start-time=00:35:00
``` 

## DShield
``` 
# Script which will download the drop list as a text file
/system script add name="Download_DShield" source={
/tool fetch url="http://joshaven.com/dshield.rsc" mode=http dst-path=disk1/dshield.rsc;
:log info "Downloaded dshield.rsc from Joshaven.com";
}

# Script which will Remove old dshield list and add new one
/system script add name="Replace_DShield" source={
/ip firewall address-list remove [find where comment="DShield"]
/import file-name=disk1/dshield.rsc;
:log info "Removed old dshield records and imported new list";
}

# Schedule the download and application of the dshield list
/system scheduler add comment="Download dshield list" interval=3d \
  name="DownloadDShieldList" on-event=Download_DShield \
  start-date=jan/01/1970 start-time=00:40:00
/system scheduler add comment="Apply dshield List" interval=3d \
  name="InstallDShieldList" on-event=Replace_DShield \
  start-date=jan/01/1970 start-time=00:45:00
``` 

## malc0de
``` 
# Script which will download the malc0de list as a text file
/system script add name="Download_malc0de" source={
/tool fetch url="http://joshaven.com/malc0de.rsc" mode=http dst-path=disk1/malc0de.rsc;
:log info "Downloaded malc0de.rsc from Joshaven.com";
}

# Script which will Remove old malc0de list and add new one
/system script add name="Replace_malc0de" source={
/ip firewall address-list remove [find where comment="malc0de"]
/import file-name=disk1/malc0de.rsc;
:log info "Removed old malc0de records and imported new list";
}

# Schedule the download and application of the malc0de list
/system scheduler add comment="Download malc0de list" interval=3d \
  name="Downloadmalc0deList" on-event=Download_malc0de \
  start-date=jan/01/1970 start-time=00:50:00
/system scheduler add comment="Apply malc0de List" interval=3d \
  name="Installmalc0deList" on-event=Replace_malc0de \
  start-date=jan/01/1970 start-time=00:55:00
``` 

## Mikrotik firewall filter rule
``` 
/ip firewall filter add chain=input action=drop \
comment="Drop new connections which source is on a blacklist" \
connection-state=new src-address-list=blacklist
```  
