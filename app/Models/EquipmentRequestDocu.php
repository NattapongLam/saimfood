<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentRequestDocu extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'equipment_request_docu_id';
    protected $table = 'equipment_request_docus';
    protected $guarded = ['equipment_request_docu_id'];
}
