# Smart Delivery Hub API

Academic back-end project built with **PHP, Laravel, and MySQL**. The API manages customers, orders, shipments, shipment tracking, and CAD-to-USD currency conversion while demonstrating object-oriented design and a service-based delivery architecture.

## Project objective

Build a REST API for a delivery workflow where orders can use different delivery providers while keeping the provider-specific logic separated from the controllers and database models.

## Technologies

- PHP 8.2+
- Laravel 12
- MySQL
- Eloquent ORM
- REST API / JSON responses
- Postman for endpoint testing
- Laravel HTTP client for an external exchange-rate service

## Main features

- Customer CRUD operations
- Order CRUD operations with customer, order-item, and shipment relationships
- Shipment creation and management
- Delivery-provider selection through a factory
- Three delivery providers: Internal Courier, Canada Post, and UPS
- Tracking support through a `Trackable` interface
- DTO-style objects for money, shipment data, and tracking results
- CAD-to-USD conversion using an external exchange-rate API
- API request/response validation and JSON responses

## Architecture and OOP concepts

The delivery layer separates provider logic from the controllers:

- `DeliveryProvider` — abstract base class
- `CanadaPostProvider`, `UpsProvider`, `InternalCourierProvider` — provider implementations
- `Trackable` — interface for providers that support tracking
- `DeliveryProviderFactory` — creates the requested provider
- `ShippingService` — coordinates shipment creation, quoting logic, and tracking
- `Money`, `ShipmentData`, `TrackingResult` — small data-transfer/value objects

This structure demonstrates abstraction, inheritance, interfaces, polymorphism, and separation of responsibilities.

## Main API endpoints

| Method | Endpoint | Purpose |
|---|---|---|
| GET / POST | `/api/customers` | List or create customers |
| GET / PUT / DELETE | `/api/customers/{customer}` | View, update, or delete a customer |
| GET / POST | `/api/orders` | List or create orders |
| GET / PUT / DELETE | `/api/orders/{order}` | View, update, or delete an order |
| GET / POST | `/api/shipments` | List or create shipments |
| GET / PUT / DELETE | `/api/shipments/{shipment}` | View, update, or delete a shipment |
| GET | `/api/track/{shipment}` | Track a shipment |
| GET | `/api/exchange-rate?amount=100` | Convert a CAD amount to USD |

## Local setup

1. Clone the repository.
2. Install PHP dependencies:
   ```bash
   composer install
   ```
3. Create the environment file:
   ```bash
   copy .env.example .env
   ```
   On macOS/Linux use `cp .env.example .env`.
4. Generate the Laravel application key:
   ```bash
   php artisan key:generate
   ```
5. Create a MySQL database named `smart_deliveryhub_db` (or update `.env` with another database name).
6. Run the migrations:
   ```bash
   php artisan migrate
   ```
7. Start the development server:
   ```bash
   php artisan serve
   ```

The API will normally be available at `http://127.0.0.1:8000/api`.

## Security / repository notes

- The real `.env` file is intentionally excluded from the repository.
- `vendor`, runtime logs, caches, sessions, and local Git history are not included.
- The original database dump with local test/session data is intentionally excluded; the database can be recreated using Laravel migrations.
- No production credentials or API keys are included.

## Academic project

This repository is presented as a school project and portfolio example. It is intended to demonstrate back-end development, REST APIs, database relationships, service-layer design, and object-oriented programming with Laravel.
