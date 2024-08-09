<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    // Invoice.php
    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function developer()
    {
        return $this->belongsTo(Developer::class);
    }
}
