<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineChecksheetDocuDt extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'machine_checksheet_docu_dt_id';
    protected $table = 'machine_checksheet_docu_dts';
    protected $guarded = ['machine_checksheet_docu_dt_id'];
    public function header()
    {
        return $this->belongsTo(MachineChecksheetDocuHd::class, 'machine_checksheet_docu_hd_id', 'machine_checksheet_docu_hd_id');
    }    
}
