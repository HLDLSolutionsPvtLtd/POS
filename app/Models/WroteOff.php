<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class WroteOff extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    protected $guarded = [];

    public function wroteoffable()
    {
        return $this->morphTo();
    }
}
