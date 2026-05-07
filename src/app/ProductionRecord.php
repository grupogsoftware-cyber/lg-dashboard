<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductionRecord extends Model
{
    protected $fillable = [
        'product_line',
        'production_date',
        'quantity_produced',
        'quantity_defects',
    ];
}
