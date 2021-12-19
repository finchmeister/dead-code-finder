# Dead Code Finder POC

## Instructions:

Start MariaDB & RabbitMQ
```
docker compose up -d
```

Import `schema.sql`

Start the UDP Server

```
php udp-server/server.php
```

Start the Analysis Worker
```
php analysis-server/worker.php
```

Either run some cli simulations
```
php client/simulate.php 100
```

Or visit the web server at http://localhost:8000
```
php -S localhost:8000 -t client/public/
```

View the RabbitMQ management console http://localhost:15672/
```
user: guest
password: guest
```