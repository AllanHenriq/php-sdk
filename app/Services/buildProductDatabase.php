<?php

namespace App\Services;

// possibly moving these requirements when migration moves
use App\Services\TCGplayer;
use App\Models\AccessToken;
use App\Models\Category;
use App\Models\Group;
use App\Models\Product;
use App\Models\ProductCondition;

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
            Category::firstOrCreate(
                ['categoryId' => $category['categoryId']],
                $category
            );
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
        $groups = Group::all();
        foreach ($groups as $group) {
            $categoryId = $group->categoryId;
            $offset = 0;
            $totalItems = 100;
            while ($totalItems > $offset) {
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
                    Product::firstOrCreate(
                        ['productId' => $product['productId']],
                        $product
                    );
                }
            }
        }
    }
}
