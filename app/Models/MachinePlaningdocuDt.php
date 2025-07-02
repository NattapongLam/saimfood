<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachinePlaningdocuDt extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'machine_planingdocu_dt_id';
    protected $table = 'machine_planingdocu_dts';
    protected $guarded = ['machine_planingdocu_dt_id'];
    public function header()
    {
        return $this->belongsTo(MachinePlaningdocuHd::class, 'machine_planingdocu_hd_id', 'machine_planingdocu_hd_id');
    }
    public function subdetails()
    {
        return $this->hasMany(MachinePlaningdocuSub::class, 'machine_planingdocu_dt_id', 'machine_planingdocu_dt_id');
    }    
}
