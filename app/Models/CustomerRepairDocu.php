<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerRepairDocu extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'customer_repair_docu_id';
    protected $table = 'customer_repair_docus';
    protected $guarded = ['customer_repair_docu_id'];
}
