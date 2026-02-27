<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Constantes de status
    public const STATUS_COMPLETED          = 'completed';
    public const STATUS_REVERSED           = 'reversed';
    public const STATUS_REVERSAL_REQUESTED = 'reversal_requested';

    // Constantes de tipos
    public const TYPE_DEPOSIT  = 'deposit';
    public const TYPE_TRANSFER = 'transfer';
    public const TYPE_REVERSAL = 'reversal';

    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transfer()
    {
        return $this->hasOne(Transfer::class);
    }

    public function sender()
    {
        return $this->hasOneThrough(User::class, Transfer::class, 'transaction_id', 'id', 'id', 'sender_id');
    }

    public function receiver()
    {
        return $this->hasOneThrough(User::class, Transfer::class, 'transaction_id', 'id', 'id', 'receiver_id');
    }

}
