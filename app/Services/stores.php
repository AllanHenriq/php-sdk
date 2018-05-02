<?php

namespace App\Services;

use TCGplayer;

class Stores
{
    public function __construct(TCGplayer $tcgplayerService)
    {
        $this->TCGCoreService = $tcgplayerService;
        $this->baseUrl = '/stores/' . $this->TCGCoreService->storeKey;
    }

    public function getSKUBuylistPrice($skuBuylistPriceId = 1)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            $this->baseUrl . '/buylist/skuprices/' . $skuBuylistPriceId,
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function listSKUBuylistPrice($params = null)
    {
        if ($params == null) {
            $params = [
                'groupId' => 1
            ]
        }
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            $this->baseUrl . '/buylist/skuprices',
            [
                'headers' => $this->TCGCoreService->headers,
                'query' => $params
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function createSKUBuylist($sku = 1, $bodyParams = null)
    {
        if ($bodyParams == null) {
            $bodyParams = [
                'skuId' => $sku,
                'price' => '.01',
                'quantity' => 0
            ];
        }
        $response = $this->TCGCoreService->guzzle->request(
            'PUT',
            $this->baseUrl . '/buylist/skus/' . $skuBuylistPriceId,
            [
                'headers' => $this->TCGCoreService->headers,
                'body' => json_encode($bodyParams)
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function updateSKUBuylistPrice($skuId = 1, $price = .01)
    {
        $bodyParams = [
            'skuId' => $skuId,
            'price' => $price
        ];
        $response = $this->TCGCoreService->guzzle->request(
            'PUT',
            $this->baseUrl . '/buylist/skus/' . $skuId . '/price',
            [
                'headers' => $this->TCGCoreService->headers,
                'body' => json_encode($bodyParams)
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function updateSKUBuylistQuantity($skuId = 1, $quantity = 1)
    {
        $bodyParams = [
            'skuId' => $skuId,
            'quantity' => $quantity
        ];
        $response = $this->TCGCoreService->guzzle->request(
            'PUT',
            $this->baseUrl . '/buylist/skus/' . $skuId . '/quantity',
            [
                'headers' => $this->TCGCoreService->headers,
                'body' => json_encode($bodyParams)
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function searchStores($bodyParams = null)
    {
        if ($bodyParams == null) {
            $bodyParams = [
                'name' => 'Game'
            ];
        }
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/stores',
            [
                'headers' => $this->TCGCoreService->headers,
                'query' => $params
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getFreeShippingOption()
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            $this->baseUrl . '/freeshipping/settings',
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getCategorySKUs($categoryId = 1)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            $this->baseUrl . '/categories/' . $categoryId . '/skus',
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getStoreAddress()
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            $this->baseUrl . '/address',
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getStoreFeedback()
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            $this->baseUrl . '/feedback',
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function setStoreStatus($status = 'inactive')
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            $this->baseUrl . '/status/' . $status,
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getCustomerSummary($token = null)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            $this->baseUrl . '/customers/' . $token,
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function searchStoreCustomers($searchParams = null)
    {
        if ($searchParams == null) {
            $searchParams = [
                'name' => 'Timmy',
                'email' => 'timmy@tolarian.academy',
                'offset' => 0,
                'limit' => 10
            ]
        }
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            $this->baseUrl . '/customers',
            [
                'headers' => $this->TCGCoreService->headers,
                'query' => $searchParams
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getCustomerAddresses($token = null)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            $this->baseUrl . '/customers/' . $token . '/addresses',
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getCustomerOrders($token = null)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            $this->baseUrl . '/customers/' . $token . '/orders',
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getStoreInfo()
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/stores/self',
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getProductInventoryQuantities($productId = 1257)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            $this->baseUrl . '/inventory/products/' . $productId . '/quantity',
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function listProductSummary($searchParams = null)
    {
        if ($searchParams == null) {
            // lot more search params available, check docs
            $searchParams = [
                'categoryId' => 1
            ];
        }

        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            $this->baseUrl . '/inventory/products',
            [
                'headers' => $this->TCGCoreService->headers,
                'query' => $searchParams
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function listProductSKUs($productId = 1257)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            $this->baseUrl . '/inventory/products/' . $productId . '/skus',
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function listRelatedProducts($productId = 1257)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            $this->baseUrl . '/inventory/products/' . $productId . '/relatedproducts',
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function listShippingOptions($productId = 1257)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            $this->baseUrl . '/inventory/products/' . $productId . '/shippingoptions',
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getSKUQuantity($skuId = 15179)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            $this->baseUrl . '/inventory/skus/' . $skuId . '/quantity',
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function incrementSKUInventoryQuantity($skuId = 15179, $quantity = 0)
    {
        $bodyParams = [
            'skuId' => $skuId,
            'quantity' => $quantity
        ];
        $response = $this->TCGCoreService->guzzle->request(
            'POST',
            $this->baseUrl . '/inventory/skus/' . $skuId . '/quantity',
            [
                'headers' => $this->TCGCoreService->headers,
                'body' => json_encode($bodyParams)
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function updateSKUInventory($skuId = 15179, $quantity = 0, $price = .01)
    {
        $bodyParams = [
            'skuId' => $skuId,
            'quantity' => $quantity,
            'price' => .01
        ];

        $response = $this->TCGCoreService->guzzle->request(
            'PUT',
            $this->baseUrl . '/inventory/skus/' . $skuId,
            [
                'headers' => $this->TCGCoreService->headers,
                'body' => json_encode($bodyParams)
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function batchUpdateStoreSKUPrices($bodyParams = null)
    {
        if ($bodyParams == null) {
            $bodyParams = [
                [
                    'skuId' => 15179,
                    'price' => 7000,
                    'channelId' => 0
                ],
                [
                    'skuId' => 21752,
                    'price' => 7000,
                    'channelId' => 0
                ]
            ]
        }
        $response = $this->TCGCoreService->guzzle->request(
            'POST',
            $this->baseUrl . '/inventory/skus/batch',
            [
                'headers' => $this->TCGCoreService->headers,
                'body' => json_encode($bodyParams)
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function updateSKUInventoryPrice($skuId = 15179, $bodyParams = null)
    {
        if ($bodyParams == null) {
            $bodyParams = [
                'price' => 0.01,
                'channelId' => 0
            ];
        }
        $response = $this->TCGCoreService->guzzle->request(
            'PUT',
            $this->baseUrl . '/inventory/skus/' . $skuId . '/price',
            [
                'headers' => $this->TCGCoreService->headers,
                'body' => json_encode($bodyParams)
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function listSKUListPrice($searchParams = null)
    {
        if ($searchParams == null) {
            // lot more search params available, check docs
            $searchParams = [
                'offset' => 0,
                'limit' => 10
            ];
        }
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            $this->baseUrl . '/inventory/skuprices',
            [
                'headers' => $this->TCGCoreService->headers,
                'query' => $searchParams
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getSKUListPrice($skuId = 15179)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            $this->baseUrl . '/inventory/skuprices/' . $skuId,
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function listAllGroups($bodyParams = null)
    {
        if ($bodyParams == null) {
            $bodyParams = [
                'offset' => 0,
                'limit' => 10
            ];
        }
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            $this->baseUrl . '/inventory/groups',
            [
                'headers' => $this->TCGCoreService->headers,
                'query' => $bodyParams
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function listAllCategories($bodyParams = null)
    {
        if ($bodyParams == null) {
            $bodyParams = [
                'offset' => 0,
                'limit' => 10
            ];
        }
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            $this->baseUrl . '/inventory/categories',
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function listTopSoldProducts($bodyParams = null)
    {
        if ($bodyParams == null) {
            $bodyParams = [
                'offset' => 0,
                'limit' => 10
            ];
        }
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            $this->baseUrl . '/inventory/topsales',
            [
                'headers' => $this->TCGCoreService->headers,
                'query' => $bodyParams
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function searchTopSoldProducts($bodyParams = null)
    {
        if ($bodyParams == null) {
            $bodyParams = [
                'categoryId' => 1
            ];
        }
        $response = $this->TCGCoreService->guzzle->request(
            'POST',
            $this->baseUrl . '/inventory/topsalessearch',
            [
                'headers' => $this->TCGCoreService->headers,
                'body' => json_encode($bodyParams)
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function listCatalogObjects($searchParams = null)
    {
        if ($searchParams == null) {
            $searchParams = [
                'q' => 'Return to Ravnica'
            ]
        }
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            $this->baseUrl . '/inventory/search',
            [
                'headers' => $this->TCGCoreService->headers,
                'query' => $searchParams
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getOrderManifest()
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            $this->baseUrl . '/orders/manifest',
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getOrderDetails($orderNumbers = '1,2')
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            $this->baseUrl . '/orders/' . $orderNumbers,
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getOrderFeedback($orderNumber = '1')
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            $this->baseUrl . '/orders/' . $orderNumber . '/feedback',
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function searchOrders($searchParams = null)
    {
        if ($searchParams == null) {
            // lot more search params available, check docs
            $searchParams = [
                'offset' => 0,
                'limit' => 10
            ];
        }
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            $this->baseUrl .'/orders/',
            [
                'headers' => $this->TCGCoreService->headers,
                'query' => $searchParams
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getOrderItems($orderNumber = '1')
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            $this->baseUrl . '/orders/' . $orderNumber . '/items',
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getOrderTrackingNumbers($orderNumber = '1')
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            $this->baseUrl . '/orders/' . $orderNumber . '/tracking',
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function addOrderTrackingNumber($orderNumber = '1', $bodyParams = null)
    {
        if ($bodyParams == null) {
            $bodyParams = [
                'trackingA', 'trackingB'
            ]
        }
        $response = $this->TCGCoreService->guzzle->request(
            'POST',
            $this->baseUrl . '/orders/' . $orderNumber . '/tracking',
            [
                'headers' => $this->TCGCoreService->headers,
                'body' => json_encode($bodyParams)
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }
}
