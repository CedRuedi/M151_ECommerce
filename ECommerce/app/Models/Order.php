<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total_price', 'status','order_code'];

    // Un ordine appartiene a un utente
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Un ordine ha più prodotti
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Un ordine ha un pagamento associato
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

}
