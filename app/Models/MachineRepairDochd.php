<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineRepairDochd extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'machine_repair_dochd_id';
    protected $table = 'machine_repair_dochds';
    protected $guarded = ['machine_repair_dochd_id'];
    public function details()
    {
        return $this->hasMany(MachineRepairDocdt::class, 'machine_repair_dochd_id', 'machine_repair_dochd_id');
    }
}
