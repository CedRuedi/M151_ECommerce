<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'payment_method', 'transaction_id', 'amount'];

    // Un pagamento è associato a un ordine
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}

