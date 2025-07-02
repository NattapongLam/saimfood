<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineGroup extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'machinegroup_id';
    protected $table = 'machine_groups';
    protected $guarded = ['machinegroup_id'];
}
