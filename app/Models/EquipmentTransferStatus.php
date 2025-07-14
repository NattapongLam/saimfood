<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentTransferStatus extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'equipment_transfer_status_id';
    protected $table = 'equipment_transfer_statuses';
    protected $guarded = ['equipment_transfer_status_id'];
}
