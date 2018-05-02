<?php

namespace App\Services;

use GuzzleHttp\Client;
use TCGplayer;

class Pricing
{
    public function __construct(TCGplayer $tcgplayerService)
    {
        $this->TCGCoreService = $tcgplayerService;
    }

    public function getMarketPriceBySKU($productConditionId = 15602)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/pricing/product/' . $productConditionId,
            [
                'headers' => $this->TCGCoreService->headers;
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function listProductPricesByGroup($groupId = 370)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/pricing/group/' . $groupId,
            [
                'headers' => $this->TCGCoreService->headers;
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function listProductMarketPrices($productIds = '83461,101491')
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/pricing/product/' . $productIds,
            [
                'headers' => $this->TCGCoreService->headers;
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function listSKUMarketPrices($skuIds = '2883545,1260372')
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/sku/' . $skuIds,
            [
                'headers' => $this->TCGCoreService->headers;
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function listProductBuylistPrices($productIds = '128661')
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/pricing/buy/product/' . $productIds,
            [
                'headers' => $this->TCGCoreService->headers;
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function listSKUBuylistPrices($skuIds = '382537,382827')
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/pricing/buy/sku/' . $skuIds,
            [
                'headers' => $this->TCGCoreService->headers;
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }
}
