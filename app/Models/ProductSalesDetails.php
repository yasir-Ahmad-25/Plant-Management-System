<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSalesDetails extends Model
{
    protected $table = 'product_sales_details';

    protected $primaryKey = 'detail_id';

    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'price',
    ];
}
 