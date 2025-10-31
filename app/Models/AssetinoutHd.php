<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetinoutHd extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'assetinout_hd_id';
    protected $table = 'assetinout_hds';
    protected $guarded = ['assetinout_hd_id'];
    public function details()
    {
        return $this->hasMany(AssetinoutDt::class, 'assetinout_hd_id', 'assetinout_hd_id');
    }
}
