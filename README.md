# README #

Symfony project with API Platform

## Start Containers ##

Run docker compose from the project folder

```bash
cd <project_path>
docker-compose up -d
```

Build DB

```bash
docker exec -it php ./bin/console doctrine:database:drop
docker exec -it php ./bin/console doctrine:database:create
docker exec -it php ./bin/console doctrine:migrations:migrate -n
docker exec -it php ./bin/console hautelook:fixtures:load -n
```

Check logs

```bash
docker-compose logs -f
```

## API DOC ##

http://localhost:5000/

### Endpoints ###

#### GET /orders/v1/ ####

Parameters

* id
* id[]
* status.id
* status.id[]
* estimatedArrival[before]
* estimatedArrival[strictly_before]
* estimatedArrival[after]
* estimatedArrival[strictly_after]

#### POST /orders/v1/ ####

Header

```
Content-Type: application/ld+json
```

Body
```json
{
	"estimatedArrival": "2022-06-27 15:16:23",
	"deliveryAddress1": "delivery_address1",
	"deliveryAddress2": "delivery_address2",
	"deliveryCity": "delivery_city",
	"deliveryPostcode": "delivery_postcode",
	"deliveryCountry": "delivery_country",
	"billingAddress1": "billing_address1",
	"billingAddress2": "billing_address2",
	"billingCity": "billing_city",
	"billingPostcode": "billing_postcode",
	"billingCountry": "billing_country"
}
```

#### PATCH /orders/v1/{id} ####

Header

```
Content-Type: application/merge-patch+json
```

Body
```json
{"status":"/order-statuses/2"}
```

#### GET /orders/v1/delayed ####

Parameters

* estimatedArrival[before]
* estimatedArrival[strictly_before]
* estimatedArrival[after]
* estimatedArrival[strictly_after]

### Command ###

```bash
docker exec -it php ./bin/console app:order:check-arrival
```
