<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerRepairStatus extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'customer_repair_status_id';
    protected $table = 'customer_repair_statuses';
    protected $guarded = ['customer_repair_status_id'];
}
