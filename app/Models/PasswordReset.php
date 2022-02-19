<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PasswordReset extends Model
{
    use HasFactory;

    protected $table = 'password_resets';

    public $timestamps = false;
    
    protected $fillable = [
        'email',
        'token',
        'created_at',
    ];

     /**
     * get Data By Token
     */
    public function getPasswordResetByTokenAndEmail($token, $email)
    {
        return $this->where('token', $token)
                    ->where('email', $email)
                    ->where('created_at', '>', Carbon::now()->subHours(1)->toDateTimeString())
                    ->first();
    }

     /**
     * delete Password Reset
     */
    public function deletePasswordReset($email)
    {
        return $this->where('email', $email)->delete();
    }

     /**
     * Store Password Reset
     */
    public function storePasswordReset($email)
    {
        return self::create([
            'email'      => $email,
            'token'      => Str::random(60),
            'created_at' => Carbon::now()
        ]);;
    }
}
