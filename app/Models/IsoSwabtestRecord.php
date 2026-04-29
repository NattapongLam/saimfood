<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsoSwabtestRecord extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'iso_swabtest_records_id';
    protected $table = 'iso_swabtest_records';
    protected $guarded = ['iso_swabtest_records_id'];
}
