<?php

/**
 * Pricing service
 *
 * Pricing service contains all of the functions that interact with pricing
 * outside of the context of a store.
 *
 */

namespace App\Services;

use GuzzleHttp\Client;
use TCGplayer;

class Pricing
{
    /**
     * Initialize the core client
     * @param TCGplayer $tcgplayerService Core service
     */
    public function __construct(TCGplayer $tcgplayerService)
    {
        $this->TCGCoreService = $tcgplayerService;
    }

    /**
     * Gets the current Market Price for the specified SKU.
     * @param  integer $productConditionId ProductCondition to get pricing for
     */
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

    /**
     * Returns all product prices associated with the specified Group.
     * @param  integer $groupId GroupID to grab product prices from
     */
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

    /**
     * Returns all product market prices for the Ids specified. Market prices that could
     * be found are returned in the results array in the response. Market prices that
     * could not be found are indicated in the errors array.
     * @param  string $productIds Comma seperated list of product ids to grab
     */
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

    /**
     * Returns all SKU market prices for the Ids specified. Market prices that could
     * be found are returned in the results array in the response. Market prices that
     * could not be found are indicated in the errors array.
     * @param  string $skuIds Comma seperated list of SKUs to get pricign for
     */
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

    /**
     * Returns all product buylist prices for the Ids specified. Buylist prices that could
     * be found are returned in the results array in the response. Buylist prices that
     * could not be found are indicated in the errors array.
     * @param  string $productIds Comma seperated list of product ids
     */
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

    /**
     * Returns all SKU buylist prices for the Ids specified. Buylist prices that could
     * be found are returned in the results array in the response. Buylist prices that
     * could not be found are indicated in the errors array.
     * @param  string $skuIds Comma seperated list of skus
     */
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
