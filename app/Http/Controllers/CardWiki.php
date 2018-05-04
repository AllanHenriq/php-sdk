<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BuildProductDatabase;

use App\Services\Catalog;

class CardWiki extends Controller
{
    public function __construct(BuildProductDatabase $builder, Catalog $catalog)
    {
        $this->builder = $builder;
        $this->catalog = $catalog;
    }

    public function testDatabase()
    {
        $this->builder->buildDatabase();
    }

    public function testListAllCategories()
    {
        dd($this->catalog->listAllCategories());
    }
}
