<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyInfo extends Model
{
    protected $table = 'company_info';

    protected $primaryKey = 'company_id';

    protected $fillable = [
        'company_name',
        'company_email',
        'company_phone',
        'company_address',
        'company_logo',
        'company_slogan',
    ];
}
