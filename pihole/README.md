# PiHole

Network-wide ad blocking https://pi-hole.net/
GitHub: https://github.com/pi-hole/docker-pi-hole
Docker: https://hub.docker.com/r/pihole/pihole/

Admin console is http://192.168.0.4:8080/admin/settings.php

## Container

Example docker-compose.yml

```
version: "3"

# More info at https://github.com/pi-hole/docker-pi-hole/#running-pi-hole-docker
# https://hub.docker.com/r/pihole/pihole/ and https://docs.pi-hole.net/

services:
  pihole:
    container_name: pihole
    image: pihole/pihole:latest
    ports:
      - "53:53/tcp"
      - "53:53/udp"
# We are not running DHCP
#      - "67:67/udp"
      - "9080:80/tcp"
      - "9443:443/tcp"
    environment:
      TZ: 'America/New_York'
      WEBPASSWORD: 'XXXXXXXXXX'
# Default DNS is localhost for home network, google (8.8.8.8), cloudflare (1.1.1.1)
      PIHOLE_DNS_: '127.0.0.1;8.8.8.8;1.1.1.1'
      FTLCONF_REPLY_ADDR4: '192.168.0.4'
    # Volumes store your data between container upgrades
    volumes:
      - './etc-pihole/:/etc/pihole/'
      - './etc-dnsmasq.d/:/etc/dnsmasq.d/'
# Recommended but not required (DHCP needs NET_ADMIN)
#   https://github.com/pi-hole/docker-pi-hole#note-on-capabilities
#    cap_add:
#      - NET_ADMIN
    restart: unless-stopped
```

## Firewall

The following firewall ports must be open on the host for the administrative console and DNS.

```bash
ufw allow from 192.168.0.1/24 to any port 53 comment "Pihole DNS"
ufw allow 9080 comment "Pihole HTTP"
ufw allow 9443 comment "Pihole HTTPS"
```

## DNS on Router

Set DNS on router to be PiHole server 192.168.0.4 with backup as cloudflare 1.1.1.1 or
google 8.8.8.8

## Upgrading

```
docker pull pihole/pihole
docker-compose down
docker-compose up -d
```
