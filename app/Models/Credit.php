<?php

namespace App\Models;

use App\Services\CreditsService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Str;

class Credit extends Model
{
    use HasFactory;

    protected $fillable = [
        'borrower_id', 'amount', 'installment_amount', 'term', 'status'
    ];

    protected $with = [
        'borrower'
    ];

    private CreditsService $creditService;

    public function __construct()
    {
        parent::__construct();

        $this->creditService = new CreditsService();
    }

    /**
     * @return void
     */
    public static function boot(): void
    {
        parent::boot();
        static::creating(function ($credit) {
            $credit->code = Str::uuid()->toString();
        });
    }

    public function getRemainingBalanceAttribute(): int
    {
        // Getting the total amount of not paid installments
        $getAllNotPayedInstallments = $this->installments()->where('paid', 1)->sum('amount');
        $getCreditTotalAmount = $this->amount;

        return ($getCreditTotalAmount - $getAllNotPayedInstallments);
    }

    public function getHumanRemainingBalanceAttribute(): float
    {
        return $this->creditService->convertToFloat($this->getRemainingBalanceAttribute());
    }

    public function getInstallmentAmountAttribute($value): float
    {
        return $this->creditService->convertToFloat($value);
    }

    public function getHumanAmountAttribute(): float
    {
        return $this->creditService->convertToFloat($this->amount);
    }

    /**
     * @return BelongsTo
     */
    public function borrower(): BelongsTo
    {
        return $this->belongsTo(Borrower::class, 'borrower_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function installments(): HasMany
    {
        return $this->hasMany(Installment::class, 'credit_id', 'id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'credit_id', 'id');
    }
}
