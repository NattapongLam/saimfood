<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachinePlaningdocuSub extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'machine_planingdocu_sub_id';
    protected $table = 'machine_planingdocu_subs';
    protected $guarded = ['machine_planingdocu_sub_id'];
     public function subheader()
    {
        return $this->belongsTo(MachinePlaningdocuDt::class, 'machine_planingdocu_dt_id', 'machine_planingdocu_dt_id');
    }
}
