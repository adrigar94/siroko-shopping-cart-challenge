## improvements
- obtener precio de linea (producto*cantidad) y obtener precio total del carrito



## API

| Method | Endpoint                | Body                            | Response OK      | Response KO     |
|--------|-------------------------|---------------------------------|------------------|-----------------|
| GET    | `/api/cart`             | `{ "user_uuid": "string" }`     | 200 - OK         | 500             |
| GET    | `/api/cart/items-count` | `{ "user_uuid": "string" }`     | 200 - OK         | 500             |
| PUT    | `/api/cart/items/{sku}` | `{ "user_uuid": "string", "name": "string", "priceInCents": 100, "url": "string", "thumbnail": "string", "quantity": 1 }` | 200 - OK        | 400, 404, 500   |
| DELETE | `/api/cart/items/{sku}` | `{ "user_uuid": "string" }`     | 204 - No Content | 404, 500        |
| POST   | `/api/cart/confirm`     | `{ "user_uuid": "string" }`     | 200 - OK         | 500             |


