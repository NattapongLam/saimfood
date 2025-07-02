<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MachinePlaningDt;

class MachinePlaningDt extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'machine_planing_dt_id';
    protected $table = 'machine_planing_dts';
    protected $guarded = ['machine_planing_dt_id'];
    public function header()
    {
        return $this->belongsTo(MachinePlaningHd::class, 'machine_planing_hd_id', 'machine_planing_hd_id');
    }    
}
