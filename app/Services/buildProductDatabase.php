<?php

namespace App\Services;

// possibly moving these requirements when migration moves
use App\Services\TCGplayer;
use App\Models\AccessToken;
use App\Models\Category;
use App\Models\Group;
use App\Models\Product;
use App\Models\ProductCondition;
use GuzzleHttp\Exception\ClientException;

class BuildProductDatabase
{
    /**
     * Initialize core client
     */
    public function __construct(TCGplayer $tcgCoreService)
    {
        $this->TCGCoreService = $tcgCoreService;
    }

    /**
     * Build out a product database from migrations
     */
    public function buildDatabase()
    {
        // grab categories
        $this->saveCategories();
        // grab groups
        $this->saveGroups();
        // grab products
        $this->saveProducts();
        $categoryCount = Category::count();
        $groupCount = Group::count();
        echo 'Database seeded with ' . $categoryCount . ' categories and '
            . $groupCount . ' groups';
    }

    /**
     * Save all categories in database
     */
    public function saveCategories()
    {
        $response = $this->TCGCoreService->guzzle->request('GET', '/catalog/categories?limit=100', [
            'headers' => $this->TCGCoreService->headers
        ]);
        $categories = json_decode($response->getBody()->getContents(), true);
        foreach ($categories['results'] as $category) {
            if ($category['categoryId'] != 55) {
                Category::firstOrCreate(
                    ['categoryId' => $category['categoryId']],
                    $category
                );
            }
        }
    }

    /**
     * Save all groups
     */
    public function saveGroups()
    {
        $categories = Category::all();
        foreach ($categories as $category) {
            $categoryId = $category->categoryId;
            $offset = 0;
            $totalItems = 100;
            while ($totalItems > $offset) {
                $response = $this->TCGCoreService->guzzle->request(
                    'GET',
                    '/catalog/categories/' . $categoryId . '/groups?limit=100&offset=' . $offset,
                    [
                        'headers' => $this->TCGCoreService->headers
                    ]
                );
                $groups = json_decode($response->getBody()->getContents(), true);
                $totalItems = $groups['totalItems'];
                $offset += 100;
                foreach ($groups['results'] as $group) {
                    $group['categoryId'] = $categoryId;
                    Group::firstOrCreate(
                        ['groupId' => $group['groupId']],
                        $group
                    );
                }
            }
        }
    }

    /**
     * Save all products in database
     */
    public function saveProducts()
    {
        // change this if you want to grab only specific categories:
        $categories = Category::all();
        foreach ($categories as $category) {
            $categoryId = $category->categoryId;
            // throws error on specific categories, skip these categories
            if ($categoryId == 21 || $categoryId == 9) {
                continue;
            }
            // make requests to grab data
            $offset = 0;
            $totalItems = 100;
            while ($totalItems > $offset) {
                try {
                    $response = $this->TCGCoreService->guzzle->request(
                        'GET',
                        '/catalog/products?categoryId=' . $categoryId
                            . '&offset=' . $offset . '&getExtendedFields=true&limit=100',
                        [
                            'headers' => $this->TCGCoreService->headers
                        ]
                    );
                    $products = json_decode($response->getBody()->getContents(), true);
                    $totalItems = $products['totalItems'];
                    $offset += 100;
                    foreach ($products['results'] as $product) {
                        $product['extendedData'] = json_encode($product['extendedData']);
                        $product['presaleInfo'] = json_encode($product['presaleInfo']);
                        Product::firstOrCreate(
                            ['productId' => $product['productId']],
                            $product
                        );
                    }
                } catch (GuzzleHttp\Exception\ClientException $e) {
                    $response = $e->getResponse();
                    $responseBodyAsString = $response->getBody()->getContents();
                    echo "Error found on category: " . $categoryId . ": " . $responseBodyAsString;
                }
            }
        }
    }
}
