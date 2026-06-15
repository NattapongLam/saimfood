<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsoNcrProduct extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'iso_ncr_products_id';
    protected $table = 'iso_ncr_products';
    protected $guarded = ['iso_ncr_products_id'];
    public function header()
    {
        return $this->belongsTo(IsoNcrList::class, 'iso_ncr_lists_id', 'iso_ncr_lists_id');
    }    
}
