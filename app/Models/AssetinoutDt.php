<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetinoutDt extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'assetinout_dt_id';
    protected $table = 'assetinout_dts';
    protected $guarded = ['assetinout_dt_id'];
    public function header()
    {
        return $this->belongsTo(AssetinoutHd::class, 'assetinout_hd_id', 'assetinout_hd_id');
    }    
}
