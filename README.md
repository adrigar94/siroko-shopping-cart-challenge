# Siroko Shopping Cart Challenge
> By Adrián García
---

## Requirements

- [x] Gestión de productos eficiente que permita: añadir, actualizar y eliminar productos del carrito.
- [x] Obtener el número total de productos en el carrito.
- [x] Confirmar la compra de carrito

## Description

En esta prueba técnica para Siroko, he aplicado arquitectura hexagonal y los principios del Domain-Driven Design (DDD).

Una de las particularidades de la API desarrollada es que no permite la creación explícita de un carrito. En su lugar, cuando se añade un producto al carrito, si no hay ningún carrito abierto para el usuario, se crea uno automáticamente. Si ya existe un carrito abierto, el producto se agrega a ese carrito existente. Esta decisión simplifica la interacción del usuario con la API y mantiene un flujo intuitivo para gestionar los carritos de compra.

La acción de confirmar un carrito simplemente cambia el estado del carrito de "abierto" a "confirmado". En un entorno de producción, esta acción probablemente involucraría la comunicación con una pasarela de pago para procesar la transacción.

Otro aspecto importante es la persistencia de los carritos en una base de datos MongoDB. Para relacionar el carrito con el usuario, se espera que el usuario pase su UUID de usuario directamente en las solicitudes a la API. Si bien esto podría plantear preocupaciones de seguridad en un entorno real, para el propósito de esta prueba técnica se consideró suficiente. Una alternativa sería guardar la información del carrito en el LocalStorage del usuario, lo que garantizaría un acceso exclusivo del usuario a su carrito. Sin embargo, elegí implementar la persistencia en MongoDB para demostrar la capacidad de crear un repositorio que interactúe con una base de datos NoSQL.

En resumen, la solución propuesta busca ser simple, fácil de mantener y adecuada para los requisitos y el alcance de la prueba técnica de Siroko.

## Improvements
- **Precio Total del Carrito**: Implementar el cálculo del precio total del carrito para proporcionar una visión completa del costo de la compra.
- **Autenticación de Usuarios**: Integrar un sistema de autenticación para eliminar la necesidad de que los usuarios pasen su user_uuid en cada solicitud.
- **Pruebas de Integración**: Agregar pruebas de integración para garantizar el correcto funcionamiento de la infraestructura.
- **Pruebas de Aceptación**: Incorporar pruebas de aceptación para verificar el comportamiento del sistema desde la perspectiva del usuario final.

## API

| Method | Endpoint                | Body                            | Response OK      | Response KO     |
|--------|-------------------------|---------------------------------|------------------|-----------------|
| GET    | `/api/cart`             | `{ "user_uuid": "string" }`     | 200 - OK         | 500             |
| GET    | `/api/cart/items-count` | `{ "user_uuid": "string" }`     | 200 - OK         | 500             |
| PUT    | `/api/cart/items/{sku}` | `{ "user_uuid": "string", "name": "string", "priceInCents": 100, "url": "string", "thumbnail": "string", "quantity": 1 }` | 200 - OK        | 400, 404, 500   |
| DELETE | `/api/cart/items/{sku}` | `{ "user_uuid": "string" }`     | 204 - No Content | 404, 500        |
| POST   | `/api/cart/confirm`     | `{ "user_uuid": "string" }`     | 200 - OK         | 500             |


## Tests
Para ejecutar los tests, utiliza el siguiente comando:
```
php bin/phpunit
```

## Set Up Project
Primero, debes iniciar el contenedor de Docker con la imagen de MongoDB. También incluye un contenedor de Mongo Express para acceder visualmente a la base de datos.
```
docker compose up -d
```

A continuación, debes iniciar el servidor Symfony.
```
symfony serve:start
```

## Explore the API with Postman
Para interactuar fácilmente con los endpoints, se proporciona una colección de Postman llamada [Adrian-Siroko-Shopping-Cart-Challenge.postman_collection.json](./Adrian-Siroko-Shopping-Cart-Challenge.postman_collection.json) en el directorio raíz del proyecto. Importa esta colección en tu cliente de Postman para comenzar a realizar solicitudes y explorar la funcionalidad de la API.