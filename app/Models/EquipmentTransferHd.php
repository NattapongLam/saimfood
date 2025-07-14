<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentTransferHd extends Model
{
    use HasFactory;
     public $timestamps = false;
    protected $primaryKey = 'equipment_transfer_hd_id';
    protected $table = 'equipment_transfer_hds';
    protected $guarded = ['equipment_transfer_hd_id'];
    public function details()
    {
        return $this->hasMany(EquipmentTransferDt::class, 'equipment_transfer_hd_id', 'equipment_transfer_hd_id');
    }
}
