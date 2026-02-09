# MPlus SSO Login

This use laravel 12, PostgreSql and Docker.

---

## Features

* Email & password authentication (login & register)
* JWT-based authentication with refresh token support
* Social login (Google & Facebook)
* Role-based access control (Admin middleware)
* Paginated & non-paginated API responses
* Docker-ready for dev & production

---

## API Endpoints

### Authentication

#### Register

`POST /api/v1/auth/register`

Creates a new user account.

---

#### Login

`POST /api/v1/auth/login`

Authenticates user and returns JWT access & refresh tokens.

---

#### Refresh Token

`POST /api/v1/auth/refresh`

Refreshes expired access token using refresh token.

---

### Social Authentication

#### Google and Facebook Login

`POST /api/v1/auth/sso`

Authenticates user using Google OAuth or Facebook OAuth.

---

### My Profile

> Requires login with any user

#### Get My Profile

`GET /api/v1/users/profile`

#### Update My Profile

`PUT /api/v1/users/profile`

---

### Admin (Optional)

> Requires admin account & admin middleware

#### Get All Users

`GET /api/v1/admin/users`

Query Params:

* `type=pagination|all` (default: pagination)
* `per_page=10`

Returns all users using `UserResource`.

---

## Environment Variables

Create a `.env` file and configure the following:

### App

```
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost
```

### Database // set database name username and password equal to your docker-compose.dev.yml db Env or your host machine db if not using docker setup

```
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=app
DB_USERNAME=app
DB_PASSWORD=secret
```

### JWT

```
JWT_SECRET=
JWT_TTL=60
JWT_REFRESH_TTL=20160
```

### Google OAuth

```
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
```

### Facebook OAuth

```
FACEBOOK_CLIENT_ID=
FACEBOOK_CLIENT_SECRET=
```

---

## Running the App (Manual)

### 1. Install Dependencies

```
composer install
```

### 2. Generate App Key & JWT Secret

```
php artisan key:generate
php artisan jwt:secret
```

### 3. Run Migration & Seeder

```
php artisan migrate --seed
```

### 4. Storage Link

```
php artisan storage:link
```

### 5. Run Server

```
php artisan serve
```

---

## Running with Docker (Development)

### 1. Build & Start Containers

```
docker compose -f docker-compose.dev.yml up -d --build
```

### 2. Initial Setup

```
docker compose -f docker-compose.dev.yml exec app sh ./sh/dev.sh
```

This will:

* Install composer dependencies
* Fresh migrate database
* Seed database
* Generate app key & JWT secret
* Create storage link

---

## Production Deployment (Docker)

### 1. Build & Start Production Containers

```
docker compose -f docker-compose.prod.yml up -d --build
```

### 2. Run Production Setup

```
docker compose -f docker-compose.prod.yml exec app sh ./sh/prod.sh
```

This will:

* Install composer dependencies (no-dev)
* Run safe migrations
* Cache config & routes

---

## Post-Deployment Checklist

* Set `APP_ENV=production`
* Set `APP_DEBUG=false`
* Ensure `.env` is not publicly accessible
* Configure reverse proxy (Nginx)
* Set correct OAuth redirect URLs
* Run `php artisan optimize`
* Setup queue worker & scheduler (if needed)

---

## Admin Account Setup

To create an admin user:

* Add `role=admin` in users table
* Or update manually via database

Admin routes are protected by `admin` middleware.

---

## Notes

* Laravel 12 uses middleware registration via `bootstrap/app.php`
* On Dev Visit `{{app_url}}/api/documentation` to see swagger documentation
* I also provide postman collection in the root folder REST_API_MPlus.postman_collection.json

---




