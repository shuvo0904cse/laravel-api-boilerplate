<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Message;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Services\ForgotPasswordService;
use Exception;

class ForgotPasswordController extends Controller
{
    /**
     * Login
     */
    public function __invoke(ForgotPasswordRequest $forgotPasswordRequest){
        try{
            $user = $this->forgotPasswordService()->forgotPassword($forgotPasswordRequest->email);
            return Message::successMessage(trans("message.send_password_reset_link"), $user->getData());
        }catch(Exception $ex){
            return Message::errorMessage($ex->getMessage());
        }
    }

    protected function forgotPasswordService()
    {
        return new ForgotPasswordService();
    }
}
