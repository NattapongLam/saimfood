<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineIssuestockHd extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'machine_issuestock_hd_id';
    protected $table = 'machine_issuestock_hds';
    protected $guarded = ['machine_issuestock_hd_id'];
    public function details()
    {
        return $this->hasMany(MachineIssuestockDt::class, 'machine_issuestock_hd_id', 'machine_issuestock_hd_id');
    }
}
