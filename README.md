# Docker Monitoring and Web Stack

This repository sets up a full Docker-based development and monitoring stack that includes:

- **MariaDB** – A relational database
- **phpMyAdmin** – A web-based database management interface
- **Grafana** – For metrics visualization
- **Prometheus** – For metrics collection
- **Nginx** – As a reverse proxy with HTTPS support
- **Apache Webserver** – For serving HTML content

## Prerequisites

- Docker and Docker Compose must be installed on your machine.
- You need to create a `.env` file before launching the stack.
- SSL certificates must be generated and placed correctly.

## Folder Structure

```
.
├── Dockerfile
├── apache-custom.conf
├── datasource.yml
├── docker-compose.yml
├── docker-phpmyadmin/
│   └── nginx.conf
├── grafana/
│   └── provisioning/
│       └── datasources/
├── html/
├── nginx.conf
├── prometheus/
│   └── prometheus.yml
├── certs/
│   ├── fullchain.pem
│   └── privkey.pem
└── .env
```
## USE

1. **Clone project**:

```bash
git clone https://github.com/MBBP1/DockerStack.git
cd DockerStack
```

## 2. Environment Variables

Create a `.env` file in the project root with the following content:

```env
# MariaDB
MYSQL_ROOT_PASSWORD=your_root_password
MYSQL_USER=your_user
MYSQL_PASSWORD=your_password
MYSQL_DATABASE=your_database

# Change localhost -> Server IP, without <>
# Change: 50718 -> Your open port
# Change: 50891 -> Your 2nd open port
# phpMyAdmin
PMA_ABSOLUTE_URI=https://localhost:50718/phpmyadmin/

# Grafana
GF_SECURITY_ADMIN_USER=admin
GF_SECURITY_ADMIN_PASSWORD=admin
GRAFANA_ROOT_URL=https://localhost:50718/grafana/

# Prometheus
PROMETHEUS_EXTERNAL_URL=https://localhost:50718/prometheus/

GF_SECURITY_ADMIN_USER=admin
GF_SECURITY_ADMIN_PASSWORD=your_admin_password

# Port numbers
NGINX_EXTERNAL_PORT=50718
WEBSERVER_EXTERNAL_PORT=50891

# Run the command below to allow only the Raspberry Pi to access the HTTP port (WEBSERVER_PORT)
# This restricts access to the webserver port to the Raspberry Pi's IP only.
# Replace <raspberrypi_ip> with the actual IP address of your Raspberry Pi,
# and <50xxx> (WEBSERVER_PORT) with the actual port number (e.g., 50891).
# Example:
# sudo ufw allow from 192.168.1.251 to any port 50891 proto tcp

# Optional: Remove any previous rule that allowed open access to the port
# This ensures that no one else can access the port.
# sudo ufw delete allow 50891

# Then explicitly deny all other traffic to that port
# This adds an extra layer of protection by making the port inaccessible to everyone else.
# sudo ufw deny 50891

# Extra -------------------------------------------------------
# Database til PHP
# This is the name of your  MySQL/MariaDB-container
MYSQL_HOST_2=mariadb 
MYSQL_USER_2=root
MYSQL_PASSWORD_2=your_root_password
#Follow labmanual (CREATE my_database1 with 2 tabels photo and temperature)
MYSQL_DATABASE_2=my_database1    

# Password for db-insert.php much match password set on raspberrypi
API_PASSWORD_2=your_password


```

## 3. SSL Certificates

Generate or provide valid SSL certificates and place them in the `certs/` directory as:

```bash
openssl req -x509 -newkey rsa:4096 -nodes -out certs/fullchain.pem -keyout certs/privkey.pem -days 365
```

> Use `localhost` or your own domain when it asks for Common Name (CN).

- `certs/fullchain.pem`
- `certs/privkey.pem`

These will be used by the Nginx container for HTTPS access.

## 4. Starting the Stack

Run the following command to start the entire stack for the first time:

```bash
docker compose up --build -d
```

## 5. Accessing Services

| Service        | URL                                   | Info                         |
|----------------|---------------------------------------|------------------------------|
| phpMyAdmin     | `https://localhost:50718/phpmyadmin`  | PMA_HOST = mariadb           |
| Grafana        | `https://localhost:50718/grafana`     | User/pass from `.env`        |
| Prometheus     | `https://localhost:50718/prometheus`  |                              |
| Webserver      | `http://localhost:50891/data-rpi`     | HTML from `html/` dir        |

## 6. Stopping the Stack

To stop and remove all containers:

```bash
docker compose down
```

## License

This project is licensed under the [MIT License](LICENSE).
