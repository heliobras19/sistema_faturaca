<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemFatura extends Model
{
    use HasFactory;
      protected $fillable = [
        'fatura_id',
        'produto_id',
        'quantidade',
        'preco_unitario',
        'valor_total',
    ];

    public function fatura()
    {
        return $this->belongsTo(Fatura::class);
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
