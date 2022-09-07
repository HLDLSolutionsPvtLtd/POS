<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Inventory extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    protected $guarded = [];
    
    public function wroteoffs()
    {
        return $this->morphOne(WroteOff::class, 'wroteoffable');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id', 'inventory_id');
    }
}
