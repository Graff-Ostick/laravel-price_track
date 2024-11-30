<?php

namespace app\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
//    use HasFactory;

    protected $fillable = [
        'email',
        'url',
        'last_checked_price',
    ];
}
