<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];

    // Un dettaglio ordine appartiene a un ordine
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // Un dettaglio ordine appartiene a un prodotto
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}

