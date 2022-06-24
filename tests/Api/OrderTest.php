<?php

declare(strict_types=1);

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Order;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class OrderTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    public function testGetCollection(): void
    {
        $response = static::createClient()->request('GET', '/orders/v1/');

        $this->assertResponseIsSuccessful();
        // Asserts that the returned content type is JSON-LD (the default)
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        // Asserts that the returned JSON is a superset of this one
        $this->assertJsonContains([
            '@context' => '/contexts/Order',
            '@id' => '/orders/v1/',
            '@type' => 'hydra:Collection',
            'hydra:totalItems' => 2
        ]);

        // Because test fixtures are automatically loaded between each test, you can assert on them
        $this->assertCount(2, $response->toArray()['hydra:member']);

        // Asserts that the returned JSON is validated by the JSON Schema generated for this resource by API Platform
        $this->assertMatchesResourceCollectionJsonSchema(Order::class);
    }

    public function testCreateOrder(): void
    {
        $response = static::createClient()->request('POST', '/orders/v1/', ['json' => [
            'estimatedArrival' => '2022-06-27 15:16:23',
            'deliveryAddress1' => 'delivery_address1',
            'deliveryAddress2' => 'delivery_address2',
            'deliveryCity' => 'delivery_city',
            'deliveryPostcode' => 'delivery_postcode',
            'deliveryCountry' => 'delivery_country',
            'billingAddress1' => 'billing_address1',
            'billingAddress2' => 'billing_address2',
            'billingCity' => 'billing_city',
            'billingPostcode' => 'billing_postcode',
            'billingCountry' => 'billing_country'
        ]]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            '@context' => '/contexts/Order',
            '@type' => 'Order'
        ]);
        $this->assertMatchesRegularExpression('~^/orders/\d+$~', $response->toArray()['@id']);
        $this->assertMatchesResourceItemJsonSchema(Order::class);
    }

    public function testCreateInvalidOrder(): void
    {
        static::createClient()->request('POST', '/orders/v1/', ['json' => [
            'estimatedArrival' => '2022-06-27 15:16:23',
            'deliveryAddress1' => 'delivery_address1',
            'deliveryAddress2' => 'delivery_address2',
            'deliveryCity' => 'delivery_city',
            'deliveryPostcode' => 'delivery_postcode',
            'deliveryCountry' => 'delivery_country',
            'billingAddress1' => 'billing_address1',
            'billingAddress2' => 'billing_address2',
            'billingCity' => 'billing_city',
            'billingPostcode' => 'billing_postcode'
            // missing country
        ]]);

        $this->assertResponseStatusCodeSame(422);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        $this->assertJsonContains([
            '@context' => '/contexts/ConstraintViolationList',
            '@type' => 'ConstraintViolationList',
            'hydra:title' => 'An error occurred',
            'hydra:description' => 'billingCountry: This value should not be blank.',
        ]);
    }

    public function testUpdateOrder(): void
    {
        $client = static::createClient();

        $client->request('PATCH', '/orders/v1/1', [
            'headers' => [
                'Content-Type: application/merge-patch+json'
            ],
            'json' => [
                'status' => '/order-statuses/2',
            ]
        ]);

        $this->assertResponseIsSuccessful();
    }
}
