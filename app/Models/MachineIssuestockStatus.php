<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineIssuestockStatus extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'machine_issuestock_statuses_id';
    protected $table = 'machine_issuestock_statuses';
    protected $guarded = ['machine_issuestock_statuses_id'];
}
