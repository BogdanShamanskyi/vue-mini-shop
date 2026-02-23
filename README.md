# 🛒 Mini Shop Module (Laravel + Vue)

## 📦 Stack

-   PHP 8.2+
-   Laravel 12
-   MySQL
-   Vue 3 (widget-based integration)
-   Pinia (global cart state)
-   Blade (server-side routing)
-   Laravel Sail (Docker)
-   Vite

------------------------------------------------------------------------

# 🚀 Installation (Docker / Sail)

## 🔹 Requirements

-   Docker
-   Docker Compose
-   Git

> Composer is not required locally if using Sail.

------------------------------------------------------------------------

## 1️⃣ Clone repository

``` bash
git clone https://github.com/BogdanShamanskyi/vue-mini-shop.git
cd vue-mini-shop
```

------------------------------------------------------------------------

## 2️⃣ Install PHP dependencies

``` bash
composer install
```

------------------------------------------------------------------------

## 3️⃣ Environment configuration

``` bash
cp .env.example .env
```

> Important: DB_HOST must be `mysql` (container name)

------------------------------------------------------------------------

## 4️⃣ Start Docker containers

``` bash
./vendor/bin/sail up -d
```

------------------------------------------------------------------------

## 5️⃣ Generate application key

``` bash
./vendor/bin/sail artisan key:generate
```

------------------------------------------------------------------------

## 6️⃣ Install frontend dependencies

``` bash
./vendor/bin/sail npm install
```

------------------------------------------------------------------------

## 7️⃣ Build frontend

Development:

``` bash
./vendor/bin/sail npm run dev
```

Production:

``` bash
./vendor/bin/sail npm run build
```

------------------------------------------------------------------------

## 8️⃣ Run migrations and seeders

``` bash
./vendor/bin/sail artisan migrate:fresh --seed
```

------------------------------------------------------------------------

## 🌐 Open in browser

http://localhost

------------------------------------------------------------------------

# 🔐 Authentication

Standard Laravel authentication (Breeze Blade).

Checkout and orders pages are available only for authenticated users.

------------------------------------------------------------------------

# 🧠 Architecture Overview

## High-Level Principles

-   Blade handles routing and page rendering.
-   Vue is used as a widget layer (not SPA).
-   Cart state is managed via Pinia (frontend) and Session (backend).
-   Business logic is extracted into Service Layer.
-   Validation is handled via FormRequest classes.
-   API errors are unified via bootstrap exception configuration.
-   Checkout process is transactional and safe against race conditions.

------------------------------------------------------------------------

## Layered Structure

### 1️⃣ Controllers

-   Thin controllers.
-   Accept validated requests.
-   Map input to DTOs.
-   Call service layer.
-   Return JSON or redirect responses.

### 2️⃣ DTO Layer

-   Encapsulates validated input data.
-   Provides clean boundaries between HTTP and service layer.

### 3️⃣ Service Layer

-   Contains business rules.
-   Performs stock validation.
-   Manages cart logic.
-   Handles transactional checkout.
-   Independent from HTTP layer.

### 4️⃣ Storage Boundary

-   CartStorage interface.
-   SessionCartStorage implementation.
-   Allows future replacement (e.g., DB storage) without changing
    service layer.

### 5️⃣ Checkout Logic

-   Wrapped in DB transaction.
-   Uses row-level locking (`lockForUpdate()`).
-   Prevents overselling under concurrent requests.
-   Deducts stock atomically.
-   Creates order + order items snapshot.

------------------------------------------------------------------------

# 🧩 Request Flow (Checkout)

1.  User submits checkout form.
2.  FormRequest validates input.
3.  Controller calls CheckoutService.
4.  Service:
    -   Locks products.
    -   Validates stock.
    -   Creates order + items.
    -   Deducts stock.
5.  Transaction commits.
6.  Cart session cleared.
7.  Redirect to orders page.

------------------------------------------------------------------------

# 📊 API Error Handling

Validation errors return unified JSON format:

``` json
{
  "message": "Validation error",
  "errors": {
    "field": ["Error message"]
  }
}
```

Configured centrally via `bootstrap/app.php`.

------------------------------------------------------------------------

# 🧪 Testing

Run tests:

``` bash
./vendor/bin/sail artisan test
```

------------------------------------------------------------------------

# 🧹 Reset database

``` bash
./vendor/bin/sail artisan migrate:fresh --seed
```

------------------------------------------------------------------------

# 🛠 Development commands

Stop containers:

``` bash
./vendor/bin/sail down
```

Rebuild containers:

``` bash
./vendor/bin/sail build --no-cache
```

------------------------------------------------------------------------

# 🎯 Design Decisions

-   Session-based cart (as allowed by requirements).
-   Transactional checkout with pessimistic locking.
-   Clean service boundaries without passing Request into services.
-   Minimal abstraction (no unnecessary repositories).
-   Widget-based Vue integration to respect server-rendered requirement.
