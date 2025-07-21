<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentRequestStatus extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'equipment_request_status_id';
    protected $table = 'equipment_request_statuses';
    protected $guarded = ['equipment_request_status_id'];
}
