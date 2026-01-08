<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsoDistributionList extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'iso_distribution_lists_id';
    protected $table = 'iso_distribution_lists';
    protected $guarded = ['iso_distribution_lists_id'];
}
