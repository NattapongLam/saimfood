<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'equipment_id';
    protected $table = 'equipment';
    protected $guarded = ['equipment_id'];
}
