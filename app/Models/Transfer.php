<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Transfer extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    protected $guarded = [];

    public function destination()
    {
        return $this->hasOne(Store::class, 'id', 'store_id');
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
