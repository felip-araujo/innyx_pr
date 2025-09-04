<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['nome','descricao','preco','data_validade','imagem','categoria_id'];

    public function categoria()
    {
        return $this->belongsTo(Category::class);
    }
}
