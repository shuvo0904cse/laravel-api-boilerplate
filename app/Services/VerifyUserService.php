<?php
namespace App\Services;

use App\Helpers\Message;
use App\Jobs\UserVerificationConfirmation;
use App\Jobs\UserVerificationLink;
use App\Models\User;
use App\Models\VerifyUser;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class VerifyUserService
{
    /**
     * verify
     */
    public function verify($credentials)
    {
        $token = $this->verifyUser()->getUserVerificationByTokenAndEmail($credentials['token'], $credentials['email']);
        if (empty($token)) Message::throwExceptionMessage(trans("message.token_not_exists"));
       
        //user details
        $user = $this->user()->userDetailsByEmail($token->email);
        if (empty($user)) Message::throwExceptionMessage(trans("message.user_not_exists"));

        DB::beginTransaction();
        try {            
            //user email verification update
            $this->updateUserEmailConfirmation($user);

            //delete password reset data
            $this->verifyUser()->deleteUserVerification($user->email);

            //send user verification confirmation
            UserVerificationConfirmation::dispatch($user);

            DB::commit();
            return Message::jsonResponse($user);
        } catch (Exception $ex) {
            DB::rollBack();
            Message::throwException($ex);
        }
    }

    /**
     * Update User Email Confirmation
     */
    public function updateUserEmailConfirmation($user)
    {
        $user->email_verified_at = Carbon::now();
        $user->save();
    }

    /**
     * generate Password Reset Link
     */
    public function generateVerifyUserLink($token)
    {
        return config("app.url") . '/verfiy/user?token=' . $token->token . '&email=' . urlencode($token->email);
    }

    /**
     * Send Verify User Link
     */
    public function sendVerifyUserLink($user)
    {
        DB::beginTransaction();
        try {
            //delete previous reset token
            $this->verifyUser()->deleteUserVerification($user->email);

            //Create Password Reset Token
            $token = $this->verifyUser()->storeUserVerification($user->email);
            
            //generate link
            $link = $this->generateVerifyUserLink($token);
            
            //send Link with queue
            UserVerificationLink::dispatch($link, $user);

            DB::commit();

            return Message::jsonResponse($user);
        } catch (Exception $ex) {
            DB::rollBack();
            Message::throwException($ex);
        }
    }

    public function verifyUser()
    {
        return new VerifyUser();
    }

    public function user()
    {
        return new User();
    }
}
