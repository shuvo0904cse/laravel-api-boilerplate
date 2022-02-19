<?php
namespace App\Services;

use App\Helpers\Message;
use App\Jobs\PasswordResetConfirmation;
use App\Models\PasswordReset;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ResetPasswordService
{
    /**
     * reset Password
     */
    public function resetPassword($credentials)
    {
        $token = $this->passwordReset()->getPasswordResetByTokenAndEmail($credentials['token'], $credentials['email']);
        if (empty($token)) Message::throwExceptionMessage(trans("message.token_not_exists"));

        //user details
        $user = $this->user()->userDetailsByEmail($token->email);
        if (empty($user)) Message::throwExceptionMessage(trans("message.user_not_exists"));

        DB::beginTransaction();
        try {            
            //user password update
            $this->updateUserPassword($user, $credentials['password']);

            //delete password reset data
            $this->passwordReset()->deletePasswordReset($user->email);

            //send reset password confirmation
            PasswordResetConfirmation::dispatch($user);

            DB::commit();
            return Message::jsonResponse($user);
        } catch (Exception $ex) {
            DB::rollBack();
            Message::throwException($ex);
        }
    }

    /**
     * Update User Password
     */
    public function updateUserPassword($user, $password)
    {
        $user->password = bcrypt($password);
        $user->remember_token = Str::random(60);
        $user->save();
    }

    public function passwordReset()
    {
        return new PasswordReset();
    }

    private function user()
    {
        return new User();
    }
}
