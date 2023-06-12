<?php

namespace App\Models;

use App\Services\CreditsService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'credit_id', 'amount'
    ];

    public function getHumanAmountAttribute(): float
    {
        $creditService = new CreditsService();
        return $creditService->convertToFloat($this->amount);
    }
}
