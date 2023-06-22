<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bank',
        'balance',
        'account_number',
        'pin'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function senderTransactions()
    {
        return $this->hasMany(Transaction::class, 'sender_id', 'id');
    }

    public function recipientTransactions()
    {
        return $this->hasMany(Transaction::class, 'recipient_id', 'id');
    }
}
