<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UmkmTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_type',
        'date',
        'title_or_product',
        'category',
        'transaction_type',
        'qty',
        'price_per_unit',
        'amount',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'qty' => 'integer',
            'price_per_unit' => 'decimal:2',
            'amount' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
