<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount', 'status', 'paid_at'
    ];

    public function paymentMethods()
    {
        return $this->belongsTo(
            PaymentMethod::class
        );
    }
}
