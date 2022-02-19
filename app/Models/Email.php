<?php

namespace App\Models;

use App\Traits\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory, BaseModel;

    protected $fillable = [
        'name',
        'email',
        'created_by',
        'updated_by'
    ];
}
