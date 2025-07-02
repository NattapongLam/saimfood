<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineRepairDocdt extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'machine_repair_docdt_id';
    protected $table = 'machine_repair_docdts';
    protected $guarded = ['machine_repair_docdt_id'];
    public function header()
    {
        return $this->belongsTo(MachineRepairDochd::class, 'machine_repair_dochd_id', 'machine_repair_dochd_id');
    }    
}
