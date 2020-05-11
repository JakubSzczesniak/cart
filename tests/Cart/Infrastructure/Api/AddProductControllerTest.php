<?php

namespace App\Tests\Cart\Infrastructure\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AddProductControllerTest
 */
class AddProductControllerTest extends WebTestCase
{
    /**
     * @dataProvider dataProvider
     *
     * @param array $fixtures
     * @param array $requestPayload
     * @param array $expected
     */
    public function test(array $fixtures, array $requestPayload, array $expected)
    {
        $client = static::createClient([], []);

        $productData['category'] = $this->category->getId();
        $productData['pickupPoints'][] = $this->pickupPoint->getId();

        $productData['contract'] = $this->contract->getId();

        $client->request(
            'POST',
            '/rental/panel/products',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($productData)
        );

        $this->assertEquals($expected['HTTP_CODE'], $client->getResponse()->getStatusCode());
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            'ok' => [
                [
                    [
                        [
                            'name' => 'A',
                            'price' => 9999,
                        ],
                        [
                            'name' => 'B',
                            'price' => 4999,
                        ]
                    ],
                ],
                [
                    'productId' => 1,
                    'cartId' => 1,
                ],
                [
                    'HTTP_CODE' => Response::HTTP_NO_CONTENT
                ]
            ],
            'bad request' => [
                [
                    'productId' => 2,
                    'cartId' => 1,
                ],
                [
                    'HTTP_CODE' => Response::HTTP_BAD_REQUEST
                ]
            ],
            'bad request 2' => [
                [
                    'productId' => 1,
                    'cartId' => 2,
                ],
                [
                    'HTTP_CODE' => Response::HTTP_BAD_REQUEST
                ]
            ],
        ];
    }
}
