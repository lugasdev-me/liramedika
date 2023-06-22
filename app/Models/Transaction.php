<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'amount',
        'sender_id',
        'recipient_id',
        'status' // 0 = pending, 1 = success, 2 = failed
    ];

    public function sender()
    {
        return $this->belongsTo(Account::class, 'sender_id', 'id');
    }

    public function recipient()
    {
        return $this->belongsTo(Account::class, 'recipient_id', 'id');
    }
}
