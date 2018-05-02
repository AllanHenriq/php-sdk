<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCondition extends Model
{
    protected $table = 'product_conditions';

    protected $fillable = [
        'productConditionId',
        'name',
        'language',
        'isFoil',
        'productId'
    ];
}
