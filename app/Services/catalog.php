<?php

/**
 * Catalog service
 *
 * Catalog service contains all of the functions that interact directly with
 * catalog outside of the context of a store.
 *
 */

namespace App\Services;

use GuzzleHttp\Client;
use App\Services\TCGplayer;

class Catalog
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
     * This function returns a paged list of all categories supported by TCGplayer.
     * @param array $queryParams Contains all sort options
     */
    public function listAllCategories($queryParams = null)
    {
        if ($queryParams == null) {
            $queryParams = [
                'limit' => 100,
                'offset' => 10
            ];
        }
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/categories',
            [
                'headers' => $this->TCGCoreService->headers,
                'query' => $queryParams
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * This function returns an array of categories whose Ids were specified in the
     * categoryIds parameter. Categories that could be found are returned in the results
     * array in the response. Categories that could not be found are indicated in the
     * errors array.
     * @param string $categoryIds Comma seperated list of categoryIds
     */
    public function categoryDetails($categoryIds = '1,2,3')
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/categories/' . $categoryIds,
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * This function returns a search manifest for the specified category. The search
     * manifest describes all of the sorting options and filters that are available for
     * this category. Its contents should be used to build requests to the POST
     * /catalog/categories/{categoryId}/search function.
     * @param integer $categoryId Category to get search manifest from
     */
    public function categorySearchManifest($categoryId = 1)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/categories/' . $categoryId . '/search/manifest',
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * This function returns an array of product Ids that match the provided search critera.
     * Use the search manifest from the GET /catalog/categories/{categoryId}/search/manifest
     * function to build requests to this function. If an invalid filter name is specified
     * in the request, it will be ignored. Use the GET /catalog/products/{productIds}
     * function to get the details about the returned product Ids.
     * @param integer $categoryId Category to search
     * @param array $bodyParams List of all optional paramaeters
     */
    public function searchCategoryProducts(
        $categoryId = 1,
        $bodyParams = null
    ) {
        if ($bodyParams == null) {
            $bodyParams = [
                'offset' => 0,
                'limit' => 10,
                'sort' => 'cardName',
                'includeAggregates' => true,
                'filters' => [['name' => 'color', 'values' => 'Blue']]
            ];
        }
        $response = $this->TCGCoreService->guzzle->post(
            '/catalog/categories/' . $categoryId . '/search',
            [
                'headers' => $this->TCGCoreService->headers,
                'body' => json_encode($bodyParams)
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * This function returns a paged list of all the groups associated with the specified
     * category.
     * @param array $params List of all optional parameters
     */
    public function listAllCategoryGroups($params)
    {
        $categoryId = !empty($params['categoryId']) ? $params['categoryId'] : 1;
        $offset = !empty($params['offset']) ? $params['offset'] : 0;
        $limit = !empty($params['limit']) ? $params['limit'] : 10;

        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/categories/' . $categoryId
              . '/groups?limit=100&offset=' . $offset
              . '&limit=' . $limit,
            [
                'headers' => $$this->TCGCoreService->headerss()
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * This function returns all available rarities associated with the specified category.
     * @param integer $categoryId Category to search
     */
    public function listAllCategoryRarities($categoryId = 1)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/categories/' . $categoryId . '/rarities',
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * This function returns all available printings associated with the specified category.
     * @param integer $categoryId Category to search
     */
    public function listAllCategoryPrintings($categoryId = 1)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/categories/' . $categoryId . '/printings',
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * This function returns all available conditions associated with the specified
     * category.
     * @param  integer $categoryId Category to search
     */
    public function listAllCategoryConditions($categoryId = 1)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/categories/' . $categoryId . '/conditions',
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * This function returns all available languages associated with the specified category.
     * @param  integer $categoryId Category to search
     */
    public function listAllCategoryLanguages($categoryId = 1)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/categories/' . $categoryId . '/languages',
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * This function returns all available media (e.g. images) associated with the specified
     * category.
     * @param  integer $categoryId Category to search
     */
    public function listAllCategoryMedia($categoryId = 1)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/categories/' . $categoryId . '/media',
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * This function returns all groups that match the specified criteria.
     * @param  array $params Array with all parameters outlined in docs
     */
    public function listAllGroupDetails($params = null)
    {
        if ($params == null) {
            $params = [
                'categoryId' => 1,
                'categoryName' => 'Magic: the Gathering',
                'isSupplemental' => null,
                'hasSealed' => null,
                'sortOrder' => 'groupName',
                'offset' => 0,
                'limit' => 10
            ];
        }

        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/groups',
            [
                'headers' => $this->TCGCoreService->headers,
                'query' => $params
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * This function returns an array of groups whose Ids were specified in the groupIds
     * parameter. Groups that could be found are returned in the results array in the
     * response. Groups that could not be found are indicated in the errors array.
     * @param  string $groupIds Comma seperated list of all group ids to search
     */
    public function getGroupDetails($groupIds = '1,2,3')
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/groups/' . $groupIds,
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * This function returns all available media (e.g. images) associated with the
     * specified group.
     * @param  string $groupId Group to get media from
     */
    public function listAllGroupMedia($groupId = '1')
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/groups/' . $groupId . '/media',
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * This function returns all products that match the specified criteria.
     * @param  array $params Array containing all search fields
     */
    public function listAllProducts($params = null)
    {
        if ($params == null) {
            $params = [
                'categoryId' => 1,
                'categoryName' => 'Magic: the Gathering',
                'groupId' => 1,
                'groupName' => 'Return to Ravnica',
                'productName' => 'Abrupt Decay',
                'getExtendedFields' => true,
                'productTypes' => 'Cards',
                'offset' => 0,
                'limit' => 10
            ];
        }

        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/products',
            [
                'headers' => $this->TCGCoreService->headers,
                'query' => $params
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * This function returns an array of products whose Ids were specified in the productIds
     * parameter. Products that could be found are returned in the results array in the
     * response. Products that could not be found are indicated in the errors array.
     * @param  string $productIds Comma seperated list of productIds
     */
    public function getProductDetails($productIds = '1027')
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/products/' . $productIds,
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * This function returns a Product's details using a code from the GTIN family of
     * product codes. NOTE: Not all products will have a GTIN.
     * @param  integer $gtin GTIN to search for
     */
    public function getProductDetailsByGTIN($gtin = 0)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/products/gtin/' . $gtin,
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * This function returns all of the available SKUs for the specified product.
     * @param  integer $productId ProductID to get SKUs from
     */
    public function listProductSKUs($productId = 1027)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/products/' . $productId . 'productconditions',
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Returns other prouducts that are commonly found in the same orders as the specified
     * anchor product.
     * @param  integer $productId ProductID to search
     */
    public function listRelatedProducts($productId = 1027)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/products/' . $productId . '/productsalsopurchased',
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Returns all available media (e.g. images) associated with the specified product.
     * @param  integer $productId ProductID to get media types from
     */
    public function listAllProductMediaTypes($productId = 1027)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/products/' . $productId . '/media',
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * This function returns an array of SKUs whose Ids were specified in the skuIds
     * parameter. SKUs that could be found are returned in the results array in the
     * response. SKUs that could not be found are indicated in the errors array.
     * @param  string $skuIds Comma seperated list of SKUs
     */
    public function getSKUDetails($skuIds = '2999708,255924')
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/skus/' . $skuIds,
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * This function returns an array contain all of the normalized conditions (AKA "super
     * conditions") supported by TCGplayer: Near Mint, Lightly Played, etc.
     */
    public function listSuperConditions()
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/superconditions',
            [
                'headers' => $this->TCGCoreService->headers
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }
}
