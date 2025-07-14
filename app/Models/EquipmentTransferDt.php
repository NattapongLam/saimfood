<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentTransferDt extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'equipment_transfer_dt_id';
    protected $table = 'equipment_transfer_dts';
    protected $guarded = ['equipment_transfer_dt_id'];
    public function header()
    {
        return $this->belongsTo(EquipmentTransferHd::class, 'equipment_transfer_hd_id', 'equipment_transfer_hd_id');
    }    
}
