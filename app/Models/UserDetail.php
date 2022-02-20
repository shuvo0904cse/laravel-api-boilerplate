<?php

namespace App\Models;

use App\Traits\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory, BaseModel;

    protected $fillable = [
        'user_id',
        'contact_number',
        'dob',
        'country',
        'state',
        'zip_code',
        'address_1',
        'address_2',
        'speciality',
        'experience',
        'web_link'
    ];
}
