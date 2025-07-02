<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MachinePlaningdocuHd extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'machine_planingdocu_hd_id';
    protected $table = 'machine_planingdocu_hds';
    protected $guarded = ['machine_planingdocu_hd_id'];
    public function details()
    {
        return $this->hasMany(MachinePlaningdocuDt::class, 'machine_planingdocu_hd_id', 'machine_planingdocu_hd_id');
    }
}
