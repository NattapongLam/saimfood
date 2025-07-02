<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineChecksheetDocuHd extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'machine_checksheet_docu_hd_id';
    protected $table = 'machine_checksheet_docu_hds';
    protected $guarded = ['machine_checksheet_docu_hd_id'];
    public function details()
    {
        return $this->hasMany(MachineChecksheetDocuDt::class, 'machine_checksheet_docu_hd_id', 'machine_checksheet_docu_hd_id');
    }
}
