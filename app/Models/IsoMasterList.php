<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsoMasterList extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'iso_master_lists_id';
    protected $table = 'iso_master_lists';
    protected $guarded = ['iso_master_lists_id'];
}
