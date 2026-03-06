<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsoSwabtestPlan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'iso_swabtest_plans_id';
    protected $table = 'iso_swabtest_plans';
    protected $guarded = ['iso_swabtest_plans_id'];
}
