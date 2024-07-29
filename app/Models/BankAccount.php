<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $guarded = [];
    // protected $fillable = [
    //     'bank_name',
    //     'account_number',
    //     'account_holder_name',
    //     'branch_address',
    //     'swift_code',
    //     'iban',
    //     'account_type',
    //     'currency',
    // ];

    // BankAccount.php
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
