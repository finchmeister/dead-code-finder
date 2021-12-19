# Dead Code Finder POC

- Client library `client/src/Client.php` used to mark possible dead code locations in the codebase. Data will be sent via UDP to the UDP server to avoid any blocking.
- UDP server `udp-server/server.php` receives the marker information and adds it to a message bus for performance.
- Analysis server worker `analysis-server/worker.php` consumes dead code messages and inserts them to MariaDB.
- `analysis-server/analyse-codebase.php` scans the code base to find all the dead code marker locations.
- `analysis-server/find-dead-code.php` compares all the dead code locations with those that are found to have been called. Those not called are considered as dead code :skull:.

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

Analyse code base to register dead code locations. Pass full document root path, e.g.
```
php analysis-server/analyse-codebase.php $(pwd)/client/public
```

Find Dead Code
```
php analysis-server/find-dead-code.php
```