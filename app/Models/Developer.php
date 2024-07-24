<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    use HasFactory;

    protected $fillable = [
        'developer_id',
        'developer_name',
        'email',
        'phone_number',
        'department',
        'designation',
        'date_of_joining',
    ];

    protected $dates = ['date_of_joining'];
}
