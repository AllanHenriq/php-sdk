<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'productId',
        'name',
        'cleanName',
        'imageUrl',
        'categoryId',
        'groupId',
        'url',
        'modifiedOn',
        'presaleInfo',
        'extendedData'
    ];
}
