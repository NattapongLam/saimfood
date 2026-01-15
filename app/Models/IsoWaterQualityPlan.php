<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsoWaterQualityPlan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'iso_water_quality_plans_id';
    protected $table = 'iso_water_quality_plans';
    protected $guarded = ['iso_water_quality_plans_id'];
}
