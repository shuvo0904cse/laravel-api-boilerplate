<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Message;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\ResetPasswordService;
use Exception;

class ResetPasswordController extends Controller
{
    /**
     * Login
     */
    public function __invoke(ResetPasswordRequest $resetPasswordRequest){
        try{
            $credentials = [
                "token"     => $resetPasswordRequest->token,
                "email"     => $resetPasswordRequest->email,
                "password"  => $resetPasswordRequest->password
            ];
            $user = $this->resetPasswordService()->resetPassword($credentials);
            return Message::successMessage(trans("message.password_changed_successfully"), $user->getData());
        }catch(Exception $ex){
            return Message::errorMessage($ex->getMessage());
        }
    }

    protected function resetPasswordService()
    {
        return new ResetPasswordService();
    }
}
