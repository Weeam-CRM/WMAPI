<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'invoice_number', 'user_id', 'invoice_date', 'total_amount', 'notes'
    // ];
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
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
