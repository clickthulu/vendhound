# Docker Setup for VendHound

This document describes how to run the VendHound application using Docker.

## Prerequisites

- Docker
- Docker Compose

## Getting Started

### 1. Environment Configuration

Create a `.env.local` file in the `app/` directory with the following content:

```env
APP_ENV=dev
APP_SECRET=ChangeThisSecretKeyInProduction

# Database configuration for Docker
DATABASE_URL="mysql://app:!ChangeMe!@database:3306/app?serverVersion=11.2.6-MariaDB&charset=utf8mb4"

# MariaDB configuration
MARIADB_DATABASE=app
MARIADB_USER=app
MARIADB_PASSWORD=!ChangeMe!
MARIADB_ROOT_PASSWORD=!ChangeMe!
MARIADB_VERSION=11.2

# Mailer configuration
MAILER_DSN=smtp://mailer:1025
EMAIL_FROM_ADDRESS=noreply@vendhound.local
EMAIL_FROM_NAME=VendHound
```

**Note:** Change the `APP_SECRET` and database password in production!

### 2. Build and Start the Containers

Navigate to the `app/` directory and run:

```bash
cd app
docker-compose up -d --build
```

This will:
- Build the PHP application container
- Start the MariaDB database
- Start the Mailpit mail server (for development)

### 3. Install Dependencies

If you need to install Composer dependencies inside the container:

```bash
docker-compose exec app composer install
```

### 4. Run Database Migrations

```bash
docker-compose exec app php bin/console doctrine:migrations:migrate
```

### 5. Access the Application

- **Application:** http://localhost:8080
- **Mailpit UI:** http://localhost:8025 (to view emails sent during development)
- **MariaDB:** localhost:3306

## Useful Commands

### View logs
```bash
docker-compose logs -f app
```

### Access the app container shell
```bash
docker-compose exec app bash
```

### Stop the containers
```bash
docker-compose down
```

### Stop and remove volumes (WARNING: destroys database data)
```bash
docker-compose down -v
```

### Rebuild containers
```bash
docker-compose up -d --build
```

### Clear Symfony cache
```bash
docker-compose exec app php bin/console cache:clear
```

## Services

- **app**: PHP 8.2 with Apache running the Symfony application (port 8080)
- **database**: MariaDB 11.2 (port 3306)
- **mailer**: Mailpit for email testing (ports 1025/8025)

## Troubleshooting

### Permission Issues

If you encounter permission issues with var/cache or var/log:

```bash
docker-compose exec app chown -R www-data:www-data var/
docker-compose exec app chmod -R 775 var/
```

### Database Connection Issues

Make sure the database container is healthy before the app starts. Check status:

```bash
docker-compose ps
```

### Composer Install Fails

If Composer install fails during build, you can run it manually:

```bash
docker-compose exec app composer install --no-interaction
```

