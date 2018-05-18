<?php

/**
 * Store service
 *
 * Store service contains all of the functions that interact with a seller's store
 *
 */

namespace App\Services;

use TCGplayer;

class Stores
{
    /**
     * Initialize the core client
     * @param TCGplayer $tcgplayerService Core service
     */
    public function __construct(TCGplayer $tcgplayerService)
    {
        $this->TCGCoreService = $tcgplayerService;
        $this->baseUrl = '/stores/' . $this->TCGCoreService->storeKey;
    }

    /**
     * Get SKU Buylist Price.
     * @param  integer $skuBuylistPriceId SKU to pull store pricing for
     */
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

    /**
     * List SKU Buylist Price
     * @param  array $params List of search parameters, can be found in docs
     */
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

    /**
     * Creates a new Buylist price for a SKU that doesn't have an existing Buylist price.
     * @param  integer $sku        SKU to create pricing for
     * @param  array  $bodyParams Contains formatted data about new pricing
     */
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

    /**
     * Updates a Buylist pricing that has already been set in the system.
     * @param  integer $skuId SKU to update
     * @param  float   $price Price to set the SKU to
     */
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

    /**
     * Updates a Buylist quantity that has already been set in the system
     * @param  integer $skuId    SKU to update
     * @param  integer $quantity Quantity to set
     */
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

    /**
     * Returns a collection of storeKey values based on the search parameters.
     * @param  array $bodyParams Array containing search parameters
     */
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

    /**
     * Gets the current Store's Free Shipping option (if exists) whose Seller
     * is associated with the user's bearer token making this API call.
     */
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

    /**
     * Get Category Skus.
     * @param  integer $categoryId Category to get SKUs from
     */
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

    /**
     * Return address information about the Store specified by the storeKey.
     */
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

    /**
     * Return feedback information about the Store specified by the storeKey.
     */
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

    /**
     * If a store's status is either Live or Hold - User Request then this
     * action may be called to flip the store between the two
     * @param string $status 'active' or 'inactive'
     */
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

    /**
     * Returns the total number of orders and total product dollar amount for
     * all orders a customer has place with the seller.
     * The token represents the unique seller and customer combination.
     * @param  string $token Token to get summary data
     */
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

    /**
     * Search Store Customers.
     * @param  array $searchParams Array containing search parameters
     */
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

    /**
     * Returns the shipping addresses associated with the orders a customer
     * has placed with the seller.
     * The token represents the unique seller and customer combination.
     * @param  string $token Token representing customer / seller combination
     */
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

    /**
     * Returns a list of orders containing the total product quantity and
     * total product dollar amount for each order a customer has placed with
     * the seller.
     * The token represents the unique seller and customer combination.
     * @param  [type] $token [description]
     * @return [type]        [description]
     */
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

    /**
     * Return general information about the current Store whose Seller is
     * associated with the user's bearer token making this API call.
     */
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

    /**
     * Get Product Inventory Quantities.
     * @param  integer $productId ProductID to get quantity from
     */
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

    /**
     * List Product Summary.
     * @param  array $searchParams Array containing search parameters
     */
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

    /**
     * Return all of the SKUs the store currently has listed for a specific product.
     * @param  integer $productId ProductID to search for
     */
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

    /**
     * Related Products are other Products that are often purchased along with
     * the specified Product.
     * @param  integer $productId ProductID to get related products from
     */
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

    /**
     * Return a list of all of the store's available shipping options for a
     * specific product.
     * @param  integer $productId ProductID to get shipping options for
     */
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

    /**
     * Get SKU Quantity.
     * @param  integer $skuId SKU to get quantity from
     */
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

    /**
     * Increments the current store's inventory of this SKU from the current
     * Store's inventory whose Seller is associated with the user's bearer
     * token making this API call.
     * @param  integer $skuId    SKU to increment quantity
     * @param  integer $quantity Quantity to add
     */
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

    /**
     * Adds or updates a SKU to the current Store's inventory whose Seller
     * is associated with the user's bearer token making this API call.
     * @param  integer $skuId    SKU to update
     * @param  integer $quantity Quantity to update
     * @param  float   $price    Price to set
     */
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

    /**
     * Perform multiple price updates asynchronously in a batch. The response
     * will contain a single GUID to identify the batch. All price updates
     * are applied to the inventory of the seller indicated by the bearer token
     * used to make this request. When the batch has been processed, a message
     * will be sent to your application's web hook containing the GUID from
     * this response.
     * @param  array $bodyParams Array containing price data
     */
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

    /**
     * Updates the current store's pricing of this SKU from the current
     * Store's inventory whose Seller is associated with the user's
     * bearer token making this API call.
     * @param  integer $skuId      SKU to update
     * @param  array  $bodyParams Array containing price and channelId
     */
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

    /**
     * This listing comes from the current Store's inventory whose Seller
     * is associated with the user's bearer token making this API call.
     * @param  array $searchParams Contains search params as found in docs
     */
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

    /**
     * Get SKU List Price.
     * @param  integer $skuId SKU to get listed price
     */
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

    /**
     * This listing comes from the current Store's inventory whose Seller
     * is associated with the user's bearer token making this API call.
     * @param  array $bodyParams Array containing search parameters as found in docs
     */
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

    /**
     * List All Categories.
     * @param  array $bodyParams Contains search parameters as outlined in docs
     */
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

    /**
     * This listing comes from the current Store's inventory whose Seller is
     * associated with the user's bearer token making this API call.
     * @param  array $bodyParams Contains search parameters as outlined in docs
     */
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

    /**
     * This listing comes from the current Store's inventory whose Seller is
     * associated with the user's bearer token making this API call.
     * Similar to the other Top Sales Search except that you can specify search
     * criteria in the sellerTssc parameter.
     * @param  array $bodyParams Contains search parameters as outlined in docs
     */
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

    /**
     * SearchResults returned can include Product, Groups, and Categories.
     * @param  array $searchParams Contains search parameters as outlined in docs
     */
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

    /**
     * Get Order search Manifest.
     */
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

    /**
     * Get Order Details.
     * @param  string $orderNumbers Comma seperated order number list
     */
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

    /**
     * Get Order Feedback.
     * @param  string $orderNumber Order number to get feedback for
     */
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

    /**
     * Search Orders.
     * @param  array $searchParams Search parameters as outlined in docs
     */
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

    /**
     * Get Order Items.
     * @param  string $orderNumber Order number to get items from
     */
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

    /**
     * Get Order Tracking Numbers.
     * @param  string $orderNumber Comma seperated list of order numbers
     */
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

    /**
     * Get Order Tracking Numbers.
     * @param string $orderNumber Order number to add tracking to
     * @param array $bodyParams  Array of tracking numbers to add
     */
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
