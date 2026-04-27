<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClbMeasuringRecord extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'clb_measuring_records_id';
    protected $table = 'clb_measuring_records';
    protected $guarded = ['clb_measuring_records_id'];
}
