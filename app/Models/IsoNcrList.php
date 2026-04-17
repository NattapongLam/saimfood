<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsoNcrList extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'iso_ncr_lists_id';
    protected $table = 'iso_ncr_lists';
    protected $guarded = ['iso_ncr_lists_id'];
}
