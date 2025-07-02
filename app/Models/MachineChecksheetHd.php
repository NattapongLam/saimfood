<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineChecksheetHd extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'machine_checksheet_hd_id';
    protected $table = 'machine_checksheet_hds';
    protected $guarded = ['machine_checksheet_hd_id'];
    public function details()
    {
        return $this->hasMany(MachineChecksheetDt::class, 'machine_checksheet_hd_id', 'machine_checksheet_hd_id');
    }
}
