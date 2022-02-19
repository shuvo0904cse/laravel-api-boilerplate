<?php

namespace App\Models;

use App\Traits\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory, BaseModel;

    protected $fillable = [
        'email',
        'is_subscribed'
    ];
    
    /**
     * Check Email Address
     */
    public function checkEmailAddress($email)
    {
        return self::query()
                ->where("email", $email)
                ->first();
    }

}
