<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 
class ProductSales extends Model
{
    protected $table = 'product_sales';

    protected $primaryKey = 'sale_id';

    protected $fillable = [
        'invoice_number',
        'customer_name',
        'customer_number',
        'customer_address',
        'sales_date',
        'discount',
        'delivery',
        'paid',
        'balance',
        'grand_total'
    ];

    protected $casts = [
        'discount' => 'float',
        'delivery' => 'float',
        'paid' => 'float',
        'balance' => 'float',
        'grand_total' => 'float',
    ];
}

