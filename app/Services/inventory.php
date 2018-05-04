<?php

/**
 * Inventory service
 *
 * Inventory service contains all of the functions that interact directly with
 * a seller's inventory. These endpoints are largely used by Quicklist.
 *
 */

namespace App\Services;

use TCGplayer;

class Inventory
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
     * This lists all the accessible ProductLists to the user identified in the
     * bearer token making the API call.
     */
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

    /**
     * Returns the ProductList specified by using the ProductListId.
     * @param  integer $productListId ProductList ID to grab
     */
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

    /**
     * Returns the ProductList specified by using the ProductListKey.
     * @param  string $productListKey Key of product list to grab
     */
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

    /**
     * Create ProductList will create a new list of products similar to how the
     * Quicklist application creates a new list.
     * @param  array  $bodyParams Array of quantities and conditions to add to list
     */
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
