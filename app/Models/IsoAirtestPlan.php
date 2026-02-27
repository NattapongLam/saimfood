<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsoAirtestPlan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'iso_airtest_plans_id';
    protected $table = 'iso_airtest_plans';
    protected $guarded = ['iso_airtest_plans_id'];
}
