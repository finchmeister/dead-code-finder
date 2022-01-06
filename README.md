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

Install and start the UDP Server

```
cd udp-server
composer install
php server.php
```

In a separate terminal, install and start the Analysis Worker
```
cd analysis-server
composer install
php worker.php
```

In another separate terminal, install the client, and either run some cli simulations to test the throughput
```
cd client
composer install
php simulate.php 10000
```

Or start the web server to run a real example
```
php -S localhost:8000 -t public/
```
Go to http://localhost:8000/phpinfo.php to trigger the dead code markers

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