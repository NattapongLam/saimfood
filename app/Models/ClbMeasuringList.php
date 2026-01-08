<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClbMeasuringList extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'clb_measuring_lists_id';
    protected $table = 'clb_measuring_lists';
    protected $guarded = ['clb_measuring_lists_id'];
}
