<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentStatus extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'equipment_status_id';
    protected $table = 'equipment_statuses';
    protected $guarded = ['equipment_status_id'];
}
