<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsoProductTestingPlan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'iso_product_testing_plans_id';
    protected $table = 'iso_product_testing_plans';
    protected $guarded = ['iso_product_testing_plans_id'];
}
