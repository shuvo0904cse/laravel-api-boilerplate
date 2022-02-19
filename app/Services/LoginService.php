<?php
namespace App\Services;

use App\Helpers\Message;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class LoginService
{
    /**
     * Login
     */
    public function login($credential){
        try{
            $data = [
                'email'     => $credential['email'],
                'password'  => $credential['password']
            ];

            if(auth()->attempt($data)) {
                $user = Auth::user(); 
                if($user->hasVerifiedEmail()){
                    return Message::jsonResponse([
                        "full_name" => $user->full_name,
                        "token"     => $this->generateToken($user)
                    ]);
                }
            }
            return Message::throwExceptionMessage("User Name or Password Invalid");
        }catch(Exception $ex){
           Message::throwException($ex);
        }
    }

    /**
     * Generate Token
     */
    protected function generateToken($user){
        return $user->createToken(config("settings.login_token_name"))->accessToken;
    }

    /**
     * User Response
     */
    protected function userResponse($user){
        return [
            "first_name"=> $user->first_name,
            "last_name" => $user->last_name,
            "email"     => $user->last_name,
            "token"     => $this->generateToken($user)
        ];
    }

    public function user()
    {
        return new User();
    }
}
