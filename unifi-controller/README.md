# Unifi Controller (Docker)

See:
- [jacobalberty/unifi](https://hub.docker.com/r/jacobalberty/unifi/)
- [Unifi Ports](https://help.ubnt.com/hc/en-us/articles/218506997-UniFi-Ports-Used)

Also: [linuxserver/unifi-controller](https://hub.docker.com/r/linuxserver/unifi-controller)

# Setup

Open required firewall ports

```bash
sudo ufw allow 8080 comment "Unifi device and controller communication"
sudo ufw allow 8081 comment "Unifi shutdown port"
sudo ufw allow 8443 comment "Unifi controller GUI/API as seen in a web browser"
sudo ufw allow 8880 comment "Unifi HTTP portal redirection"
sudo ufw allow 8843 comment "Unifi HTTPS portal redirection"
sudo ufw allow 6789 comment "Unifi mobile speed test"
sudo ufw allow 3478/udp comment "Unifi Session Traversal Utilities for NAT (STUN)"
sudo ufw allow 10001/udp comment "Unifi device discovery"
```

Set up docker-compose.yml

```
version: "2"

# See https://hub.docker.com/r/jacobalberty/unifi/

services:
  pihole:
    container_name: unifi
    image: jacobalberty/unifi:latest
    ports:
      - "8080:8080/tcp"
      - "8081:8081/tcp"
      - "8443:8443/tcp"
      - "8843:8843/tcp"
      - "8880:8880/tcp"
      - "6789:6789/tcp"
      - "3478:3478/udp"
      - "10001:10001/udp"
    environment:
      TZ: 'America/New_York'
      RUNAS_UID0: false
    volumes:
      - './unifi/:/unifi/'
    restart: unless-stopped
```

Alternatively

```bash
docker run --rm --init -e TZ='America/New_York' \
    -p 8080:8080 -p 8081:8081 -p 8443:8443 -p 8843:8843 -p 8880:8880 -p 6789:6789 \
    -p 3478:3478/udp -p 10001:10001/udp \
    -v `pwd`/data:/unifi \
    --name unifi \
    jacobalberty/unifi:latest
```

# Setup and Configuration

1. Start container `docker-compose up`
2. Edit unifi/data/system.properties to set docker host: `system_ip=192.168.0.4`
3. Restart container `docker-compose restart`

## Site Setup

https://192.168.0.1:8443/

Config screen on startup:
Controller name: Unifi
Select advanced setup
Disable remote and ubiquti account, set up local admin: admin / **password**

Automatically Optimize network: yes
Enable auto backup: yes

WiFi Setup: WIFI-NETWORK-NAME
Combine 2 & 5 GHz network names into one: yes

# Adopting Existing Access Points

See https://help.ubnt.com/hc/en-us/articles/205146020-UniFi-Advanced-Adoption-of-a-Managed-By-Other-Device

To adopt devices associated with another controller:
1. Go to the old controller
2. Settings > Site > Enable advanced features: true
   This enables Device Authentication menu and a randomized ssh username and password. Use this
   password to force adoption of the access points.
3. On the new controller: Click the device, click the plus sign and force adoption using the
   username and password from the previous step.
