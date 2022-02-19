<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Message;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\LoginService;
use Exception;

class LoginController extends Controller
{
    /**
     * Login
     */
    public function __invoke(LoginRequest $loginRequest){
        try{
            $credential = [
                "email"         => $loginRequest->email,
                "password"      => $loginRequest->password,
            ];
            $user = $this->loginService()->login($credential);
            return Message::successMessage(trans("message.executed_successfully"), $user->getData());
        }catch(Exception $ex){
            return Message::errorMessage($ex->getMessage());
        }
    }

    protected function loginService()
    {
        return new LoginService();
    }
}
