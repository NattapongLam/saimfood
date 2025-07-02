<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachinePlaningHd extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'machine_planing_hd_id';
    protected $table = 'machine_planing_hds';
    protected $guarded = ['machine_planing_hd_id'];
    public function details()
    {
        return $this->hasMany(MachinePlaningDt::class, 'machine_planing_hd_id', 'machine_planing_hd_id');
    }
}
