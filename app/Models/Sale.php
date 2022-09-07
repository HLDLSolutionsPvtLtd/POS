<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Sale extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    protected $guarded = [];
    protected $with = ['products', 'transaction', 'customer'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'sale_product')->withPivot(['quantity', 'discount_amount']);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function customer()
    {
        return $this->hasOne(User::class, 'id', "user_id");
    }
}
