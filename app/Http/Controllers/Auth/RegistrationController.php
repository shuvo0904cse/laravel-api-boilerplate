<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Message;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Services\RegistrationService;
use Exception;

class RegistrationController extends Controller
{
    /**
     * Registration
     */
    public function __invoke(RegistrationRequest $registrationRequest){
        try{
            $registration = [
                "first_name"    => $registrationRequest->first_name,
                "last_name"     => $registrationRequest->last_name,
                "email"         => $registrationRequest->email,
                "password"      => $registrationRequest->password,
            ];
            $user = $this->registrationService()->registration($registration);
            return Message::successMessage(trans("message.executed_successfully"), $user->getData());
        }catch(Exception $ex){
            return Message::errorMessage($ex->getMessage());
        }
    }

    protected function registrationService()
    {
        return new RegistrationService();
    }
}
