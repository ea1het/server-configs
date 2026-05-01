# WHAT IS IT?

redis       → internal DNS name for Redis  
aggregator  → worker service, no exposed port  
bff         → internal DNS name used by HAProxy  
haproxy     → only public-facing service  

# HOW THIS WORKS

Under notmal use, this is the most important command to remember:

```
docker compose up -d --scale bff=2
```

as this launches all docker compose with 2 replicas of the BFF, that means, aproximately 4000 SSE sessions in a pool.

# OTHER PROCEDURES

For first use, run this:

```
docker compose --profile certbot run --rm certbot-dns-hetzner
```

Rest of executions, normally it will be used:

```
cd /opt/outdoordx
docker compose pull
docker compose up -d
docker compose ps
```

To check for logs in docker, run this:

```
docker compose logs bff --tail=100
docker compose logs aggregator --tail=100
docker compose logs haproxy --tail=100
docker compose logs redis --tail=100
```

For live logs, it would be better to run this:

```
docker compose logs -f bff
docker compose logs -f aggregator
docker compose logs -f haproxy
docker compose logs -f redis
```

# USEFUL COMMANDS

### For Redis:

Ping:
```
docker compose exec redis redis-cli ping
```

Keys:
```
docker compose exec redis redis-cli keys '*'
```

Streams:
```
docker compose exec redis redis-cli xinfo streams
```

Memory:
```
docker compose exec redis redis-cli info memory
```

### For HAPRoxy

Check config validity
```
docker compose exec haproxy haproxy -c -f /usr/local/etc/haproxy/haproxy.cfg
```
