<?php

namespace App\Models;

use App\Services\CreditsService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Borrower extends Model
{
    protected $fillable = [
        'first_name', 'last_name'
    ];

    /**
     * @return string
     */
    public function getNameAttribute(): string
    {
        return ($this->first_name ?? '') . ' ' . ($this->last_name ?? '');
    }

    /**
     * @return int
     */
    public function getActiveCreditsTotalAmountAttribute(): int
    {
        // Getting the total amount of the active credits
        return $this->credits()->where('status', 0)->sum('amount');
    }

    /**
     * @return float
     */
    public function getHumanActiveCreditsTotalAmountAttribute(): float
    {
        $creditService = new CreditsService();
        // Getting the total amount of the active credits for human
        return $creditService->convertToFloat($this->getActiveCreditsTotalAmountAttribute());
    }


    /**
     * @return HasMany
     */
    public function credits(): HasMany
    {
        return $this->hasMany(Credit::class, 'borrower_id', 'id');
    }


}
