<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Message;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\VerifyUserRequest;
use App\Services\ForgotPasswordService;
use App\Services\VerifyUserService;
use Exception;

class VerifyUserController extends Controller
{
    /**
     * Login
     */
    public function __invoke(VerifyUserRequest $verifyUserRequest){
        try{
            $user = $this->verifyUserService()->verify($verifyUserRequest->all());
            return Message::successMessage(trans("message.user_verification_successfully"), $user->getData());
        }catch(Exception $ex){
            return Message::errorMessage($ex->getMessage());
        }
    }

    protected function verifyUserService()
    {
        return new VerifyUserService();
    }
}
