<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerRepairSub extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'customer_repair_sub_id';
    protected $table = 'customer_repair_subs';
    protected $guarded = ['customer_repair_sub_id'];
}
