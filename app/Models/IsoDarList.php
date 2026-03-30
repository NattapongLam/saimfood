<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsoDarList extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'iso_dar_lists_id';
    protected $table = 'iso_dar_lists';
    protected $guarded = ['iso_dar_lists_id'];
    public function details()
    {
        return $this->hasMany(IsoDarSub::class, 'iso_dar_lists_id', 'iso_dar_lists_id');
    }
}
