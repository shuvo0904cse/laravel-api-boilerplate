<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Message;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserPermissionRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
     /**
     * index
     */
    public function index(Request $request)
    {
        try{
            $role = $this->userService()->lists($request->all());
            return Message::successMessage(trans("message.execute_successfully"), $role->getData());
        }catch(Exception $ex){
            return Message::errorMessage($ex->getMessage());
        }
    }

    /**
     *  Store
     */
    public function store(UserRequest $request)
    {
        try{
            $role = $this->userService()->store($request->all());
            return Message::successMessage(trans("message.save_successfully"), $role->getData());
        }catch(Exception $ex){
            return Message::errorMessage($ex->getMessage());
        }
    }

    /**
     * Update
     */
    public function update(UserRequest $request, User $user)
    {
        try{
            $role = $this->userService()->update($request->all(), $user->id);
            return Message::successMessage(trans("message.update_successfully"), $role->getData());
        }catch(Exception $ex){
            return Message::errorMessage($ex->getMessage());
        }
    }

    /**
     * Destroy
     */
    public function destroy(User $user)
    {
        try{
            $this->userService()->delete($user);
            return Message::successMessage(trans("message.delete_successfully"));
        }catch(Exception $ex){
            return Message::errorMessage($ex->getMessage());
        }
    }

    /**
     * Permission
     */
    public function permission(UserPermissionRequest $request, User $user)
    {
        try{
            $this->userService()->assignPermission($request->permissions, $user->id);
            return Message::successMessage(trans("message.save_successfully"));
        }catch(Exception $ex){
            return Message::errorMessage($ex->getMessage());
        }
    }

    protected function userService(){
        return new UserService();
    }
}
