<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['nome'];

    public function produtos()
    {
        return $this->hasMany(Product::class);
    }
}
