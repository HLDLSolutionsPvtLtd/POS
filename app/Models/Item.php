<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Item extends Model
{
    use HasFactory, Searchable;
    protected $guarded = [];

    protected function makeAllSearchableUsing($query)
    {
        return $query->with('author');
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }
}
