// possibly moving these requirements when migration moves
use App\Models\AccessToken;
use App\Models\Category;
use App\Models\Group;
use App\Models\Product;
use App\Models\ProductCondition;

/* public function buildDatabase()
{
    // grab categories
    //$this->saveCategories();

    // grab groups
    //$this->saveGroups();

    // grab products
    $this->saveProducts();

    $categoryCount = Category::count();
    $groupCount = Group::count();
    echo 'Database seeded with ' . $categoryCount . ' categories and '
        . $groupCount . ' groups';
}

public function saveCategories()
{
    $response = $this->tcgGuzzleClient->request('GET', '/catalog/categories?limit=100', [
        'headers' => $this->getHeaders()
    ]);
    $categories = json_decode($response->getBody()->getContents(), true);
    foreach ($categories['results'] as $category) {
        Category::firstOrCreate(
            ['categoryId' => $category['categoryId']],
            $category
        );
    }
}

public function saveGroups()
{
    $categories = Category::all();
    foreach ($categories as $category) {
        $categoryId = $category->categoryId;
        $offset = 0;
        $totalItems = 100;
        while ($totalItems > $offset) {
            $response = $this->tcgGuzzleClient->request(
                'GET',
                '/catalog/categories/' . $categoryId . '/groups?limit=100&offset=' . $offset,
                [
                    'headers' => $this->getHeaders()
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

public function saveProducts()
{
    $groups = Group::all();
    foreach ($groups as $group) {
        $categoryId = $group->categoryId;
        $categoryId = 1;
        $offset = 0;
        $totalItems = 100;
        while ($totalItems > $offset) {
            $response = $this->tcgGuzzleClient->request(
                'GET',
                '/catalog/products?categoryId=' . $categoryId
                    . 'offset=' . $offset . '&getExtendedFields=true',
                [
                    'headers' => $this->getHeaders()
                ]
            );
            $products = json_decode($response->getBody()->getContents(), true);
            dd($products);
            $totalItems = $products['totalItems'];
            $offset += 100;
            //$group['categoryId'] = $categoryId;
            foreach ($products['results'] as $product) {
                Product::firstOrCreate(
                    ['productId' => $product['productId']],
                    $product
                );
            }
            dd(Product::first());
        }
    }
} */
