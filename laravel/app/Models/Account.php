<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $table = 'accounts';

    protected $primaryKey = 'register_id';

    protected $fillable = [
        'login',
        'password',
        'phone',
    ];
}
