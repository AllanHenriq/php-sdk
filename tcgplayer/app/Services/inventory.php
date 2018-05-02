<?php

namespace App\Services;

use TCGplayer;

class Inventory
{
    public function __construct(TCGplayer $tcgplayerService)
    {
        $this->TCGCoreService = $tcgplayerService;
    }

    public function listAllProductLists()
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/inventory/productLists',
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getProductListById($productListId = 1)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/inventory/productlists/' . $productListId,
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getProductListByKey($productListKey = 'key')
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/inventory/productlists/' . $productListKey,
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function createProductList($bodyParams = [['quantity' => 2, 'productConditionId' => 21163]])
    {
        $response = $this->TCGCoreService->guzzle->post(
            '/inventory/productlists',
            [
                'headers' => $this->TCGCoreService->headers,
                'body' => json_encode($bodyParams)
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }
}
