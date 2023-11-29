# Laravel Todo List REST API

This Laravel project implements a REST API for a Todo List. The API provides endpoints for managing tasks and users, allowing users to create, update, complete, and delete tasks.

## Requirements

- **Docker:** Ensure you have a stable version of [Docker](https://docs.docker.com/engine/install/) installed.
- **Docker Compose:** Make sure you have a compatible version of [Docker Compose](https://docs.docker.com/compose/install/#install-compose).

## How To Deploy

### Initial Setup

### For the first time only:

```bash
cp .env.example .env
docker-compose up -d
```
---
```bash
docker exec -it todo_list_laravel_api_container bash
composer setup
```
or
```bash
docker exec todo_list_laravel_api_container bash -c 'composer setup'
```
___
___
### From the Second Time Onwards:
```bash
docker-compose up -d
docker exec -it todo_list_laravel_api_container bash
```
___
___
### Rebuild Docker images:
```bash
docker-compose build
```
#### *without cache
```bash
docker-compose build --no-cache
```
___
___
### Stop Docker containers
```bash
docker-compose stop
```

#### Stop and remove Docker containers, networks, and volumes created by

```bash
docker-compose down
```
___
___
## Database Operations

### Run All Outstanding Migrations

```bash
docker exec todo_list_laravel_api_container bash -c 'php artisan migrate'
```

### Roll Back the Latest Migration Operation

```bash
docker exec todo_list_laravel_api_container bash -c 'php artisan migrate:rollback'
```

### Seed Your Database

```bash
docker exec todo_list_laravel_api_container bash -c 'php artisan db:seed'
```

This seed creates two users with emails:
- test1@example.com (password: 'password')
- test2@example.com (password: 'password')

### Fresh Database and Seed

```bash
docker exec todo_list_laravel_api_container bash -c 'php artisan migrate:fresh --seed'
```
___
___
## Open an Interactive Shell (Bash) Inside a Running Docker Container

```bash
docker exec -it todo_list_laravel_api_container bash
```
___
___
## Documentation

Explore the API using Swagger documentation by navigating to [http://127.0.0.1:8008/api/docs](http://127.0.0.1:8008/api/docs).

To use a different port other than **`8008`**, edit the **`APP_PORT=8008`** in the .env file.

This interactive documentation provides detailed information about the available endpoints, request payloads, and responses. Use it to test and understand the functionalities offered by the Todo List REST API.
___
___
## Running Tests

To run tests for the Laravel Todo List REST API, execute the following command inside the running Docker container:

```bash
docker exec todo_list_laravel_api_container bash -c 'php artisan test php artisan test --env=testing'
```
