<?php

namespace App\Models;

use App\Services\CreditsService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Installment extends Model
{
    use HasFactory;

    protected $fillable = [
        'credit_id', 'amount', 'payment_date', 'payed'
    ];

    public function getHumanAmountAttribute(): float
    {
        $creditService = new CreditsService();
        return $creditService->convertToFloat($this->amount);
    }

    /**
     * @return BelongsTo
     */
    public function credit(): BelongsTo
    {
        return $this->belongsTo(Credit::class, 'credit_id', 'id');
    }
}
