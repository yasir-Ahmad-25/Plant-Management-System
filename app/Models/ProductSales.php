<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 
class ProductSales extends Model
{
    protected $table = 'product_sales';

    protected $primaryKey = 'sale_id';

    protected $fillable = [
        'customer_name',
        'customer_number',
        'customer_address',
        'sales_date',
        'discount',
        'delivery',
        'paid',
        'balance',
    ];
}
