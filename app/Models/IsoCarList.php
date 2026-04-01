<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsoCarList extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'iso_car_lists_id';
    protected $table = 'iso_car_lists';
    protected $guarded = ['iso_car_lists_id'];
}
