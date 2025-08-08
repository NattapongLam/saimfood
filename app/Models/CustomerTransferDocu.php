<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerTransferDocu extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'customer_transfer_docu_id';
    protected $table = 'customer_transfer_docus';
    protected $guarded = ['customer_transfer_docu_id'];
}
