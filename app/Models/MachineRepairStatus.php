<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineRepairStatus extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'machine_repair_status_id';
    protected $table = 'machine_repair_statuses';
    protected $guarded = ['machine_repair_status_id'];
}
