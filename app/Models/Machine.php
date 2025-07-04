<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'machine_id';
    protected $table = 'machines';
    protected $guarded = ['machine_id'];
}
