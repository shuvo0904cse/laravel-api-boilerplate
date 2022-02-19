<?php

namespace App\Models;

use App\Traits\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory, BaseModel;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'subject',
        'message'
    ];
}
