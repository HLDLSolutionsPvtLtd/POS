<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    protected $guarded = [];

    public function wroteoffs()
    {
        return $this->morphOne(WroteOff::class, 'wroteoffable');
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function item()
    {
        return $this->hasOneThrough(Inventory::class, Item::class, 'item_id', 'inventory_id', 'id', 'id');
    }
}
