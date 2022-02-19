<?php
namespace App\Services;

use App\Helpers\Message;
use App\Jobs\PasswordResetLink;
use App\Jobs\SendPasswordResetLink;
use App\Models\PasswordReset;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class ForgotPasswordService
{
    /**
     * Send Password Link
     */
    public function forgotPassword($email)
    {
        $user = $this->user()->userDetailsByEmail($email);
        if (empty($user)) Message::throwExceptionMessage(trans("message.user_not_exists"));

        DB::beginTransaction();
        try {
            //delete previous reset token
            $this->passwordReset()->deletePasswordReset($user->email);

            //Create Password Reset Token
            $token = $this->passwordReset()->storePasswordReset($user->email);
            
            //generate link
            $link = $this->generatePasswordResetLink($token);
            
            //send Password Link with queue
            PasswordResetLink::dispatch($link, $user);

            DB::commit();

            return Message::jsonResponse($user);
        } catch (Exception $ex) {
            DB::rollBack();
            Message::throwException($ex);
        }
    }

    /**
     * generate Password Reset Link
     */
    public function generatePasswordResetLink($token)
    {
        return config("app.url") . '/password/reset?token=' . $token->token . '&email=' . urlencode($token->email);
    }

    public function passwordReset()
    {
        return new PasswordReset();
    }

    public function user()
    {
        return new User();
    }
}
