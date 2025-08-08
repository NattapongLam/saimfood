<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerTransferStatus extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'customer_transfer_status_id';
    protected $table = 'customer_transfer_statuses';
    protected $guarded = ['customer_transfer_status_id'];
}
