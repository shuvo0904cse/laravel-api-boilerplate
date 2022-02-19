<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class VerifyUser extends Model
{
    use HasFactory;
    
    protected $table = 'user_verifications';

    public $timestamps = false;
    
    protected $fillable = [
        'email',
        'token',
        'created_at',
    ];

     /**
     * get Data By Token
     */
    public function getUserVerificationByTokenAndEmail($token, $email)
    {
        return $this->where('token', $token)
                    ->where('email', $email)
                    ->first();
    }

     /**
     * delete User Verification
     */
    public function deleteUserVerification($email)
    {
        return $this->where('email', $email)->delete();
    }

     /**
     * Store
     */
    public function storeUserVerification($email)
    {
        return self::create([
            'email'      => $email,
            'token'      => Str::random(60),
            'created_at' => Carbon::now()
        ]);;
    }
}
