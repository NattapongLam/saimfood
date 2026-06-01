<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsoAirtestRecord extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'iso_airtest_records_id';
    protected $table = 'iso_airtest_records';
    protected $guarded = ['iso_airtest_records_id'];
}
