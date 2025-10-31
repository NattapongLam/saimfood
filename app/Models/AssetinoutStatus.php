<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetinoutStatus extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'assetinout_statuses_id';
    protected $table = 'assetinout_statuses';
    protected $guarded = ['assetinout_statuses_id'];
}
