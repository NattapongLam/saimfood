<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClbMeasuringPlan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'clb_measuring_plans_id';
    protected $table = 'clb_measuring_plans';
    protected $guarded = ['clb_measuring_plans_id'];
}
