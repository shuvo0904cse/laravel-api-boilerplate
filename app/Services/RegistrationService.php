<?php
namespace App\Services;

use App\Helpers\Message;
use App\Services\VerifyUserService;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class RegistrationService
{
    /**
     * registration
     */
    public function registration($registration){
        DB::beginTransaction();
        try{
            //store User
          $user = $this->storeUser($registration);

          //send User verification
          $this->verifyUserService()->sendVerifyUserLink($user);

          DB::commit();
          return Message::jsonResponse($user);
        }catch(Exception $ex){
           DB::rollBack();
           Message::throwException($ex);
        }
    }

    /**
     * Store User
     */
    protected function storeUser($user){
          return User::create([
              "first_name" => $user['first_name'],
              "last_name" => $user['last_name'],
              "email" => $user['email'],
              "password" => bcrypt($user['password']),
          ]);
    }

    protected function verifyUserService(){
        return new VerifyUserService();
    }
    
}
