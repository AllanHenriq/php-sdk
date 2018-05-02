<?php

namespace App\Services;

use GuzzleHttp\Client;
use TCGplayer;

class Catalog
{
    public function __construct(TCGplayer $tcgplayerService)
    {
        $this->TCGCoreService = $tcgplayerService;
    }

    public function listAllCategories($limit = 100, $offset = 0, $sortOrder = 'name', $sortDesc = 'true')
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/categories?limit=' . $limit . '&offset=' . $offset
              . '&sortOrder=' . $sortOrder . '&sortDesc=' . $sortDesc,
            [
                'headers' => $this->TCGCoreService->headers;
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    /*
    Accepts comma seperated list of categories as a string
     */
    public function categoryDetails($categoryIds = '1,2,3')
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/categories/' . $categoryIds,
            [
                'headers' => $this->TCGCoreService->headers;
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function categorySearchManifest($categoryId = 1)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/categories/' . $categoryId . '/search/manifest',
            [
                'headers' => $this->TCGCoreService->headers;
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

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
                'headers' => $this->getHeaders()
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function listAllCategoryRarities($categoryId = 1)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/categories/' . $categoryId . '/rarities',
            [
                'headers' => $this->getHeaders()
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function listAllCategoryPrintings($categoryId = 1)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/categories/' . $categoryId . '/printings',
            [
                'headers' => $this->getHeaders()
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function listAllCategoryConditions($categoryId = 1)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/categories/' . $categoryId . '/conditions',
            [
                'headers' => $this->getHeaders()
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function listAllCategoryLanguages($categoryId = 1)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/categories/' . $categoryId . '/languages',
            [
                'headers' => $this->getHeaders()
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function listAllCategoryMedia($categoryId = 1)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/categories/' . $categoryId . '/media',
            [
                'headers' => $this->getHeaders()
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

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
                'headers' => $this->getHeaders(),
                'query' => $params
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getGroupDetails($groupIds = '1,2,3')
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/groups/' . $groupIds,
            [
                'headers' => $this->getHeaders()
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function listAllGroupMedia($groupId = '1')
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/groups/' . $groupId . '/media',
            [
                'headers' => $this->getHeaders()
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

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
                'headers' => $this->getHeaders(),
                'query' => $params
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getProductDetails($productIds = '1027')
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/products/' . $productIds,
            [
                'headers' => $this->getHeaders()
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getProductDetailsByGTIN($gtin = 0)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/products/gtin/' . $gtin,
            [
                'headers' => $this->getHeaders()
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function listProductSKUs($productId = 1027)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/products/' . $productId . 'productconditions',
            [
                'headers' => $this->getHeaders()
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function listRelatedProducts($productId = 1027)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/products/' . $productId . '/productsalsopurchased',
            [
                'headers' => $this->getHeaders()
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function listAllProductMediaTypes($productId = 1027)
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/products/' . $productId . '/media',
            [
                'headers' => $this->getHeaders()
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getSKUDetails($skuIds = '2999708,255924')
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/skus/' . $skuIds,
            [
                'headers' => $this->getHeaders()
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function listSuperConditions()
    {
        $response = $this->TCGCoreService->guzzle->request(
            'GET',
            '/catalog/superconditions',
            [
                'headers' => $this->getHeaders()
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }
}
