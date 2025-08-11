<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'product_categories'; 
    protected $primaryKey = 'product_category_id'; 
    protected $fillable = [
        'category_name',
        'category_description',
    ];
}
