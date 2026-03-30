<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsoDarSub extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'iso_dar_subs_id';
    protected $table = 'iso_dar_subs';
    protected $guarded = ['iso_dar_subs_id'];
    public function header()
    {
        return $this->belongsTo(IsoDarList::class, 'iso_dar_lists_id', 'iso_dar_lists_id');
    }    
}
