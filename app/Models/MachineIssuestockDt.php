<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineIssuestockDt extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'machine_issuestock_dt_id';
    protected $table = 'machine_issuestock_dts';
    protected $guarded = ['machine_issuestock_dt_id'];
    public function header()
    {
        return $this->belongsTo(MachineIssuestockHd::class, 'machine_issuestock_hd_id', 'machine_issuestock_hd_id');
    }    
}
