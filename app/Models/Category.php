<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'categoryId',
        'name',
        'modifiedOn',
        'displayName',
        'seoCategoryName',
        'sealedLabel',
        'nonSealedLabel',
        'conditionGuideUrl',
        'isScannable',
        'popularity'
    ];
}
