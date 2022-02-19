<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Message;
use App\Http\Controllers\Controller;
use App\Http\Requests\RolePermissionRequest;
use App\Http\Requests\RoleRequest;
use App\Models\Role;
use App\Services\RoleService;
use Exception;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * index
     */
    public function index(Request $request)
    {
        try{
            $role = $this->roleService()->lists($request->all());
            return Message::successMessage(trans("message.execute_successfully"), $role->getData());
        }catch(Exception $ex){
            return Message::errorMessage($ex->getMessage());
        }
    }

    /**
     *  Store
     */
    public function store(RoleRequest $request)
    {
        try{
            $role = $this->roleService()->store($request->all());
            return Message::successMessage(trans("message.save_successfully"), $role->getData());
        }catch(Exception $ex){
            return Message::errorMessage($ex->getMessage());
        }
    }

    /**
     * Update
     */
    public function update(RoleRequest $request, Role $role)
    {
        try{
            $role = $this->roleService()->update($request->all(), $role->id);
            return Message::successMessage(trans("message.update_successfully"), $role->getData());
        }catch(Exception $ex){
            return Message::errorMessage($ex->getMessage());
        }
    }

    /**
     * Destroy
     */
    public function destroy(Role $role)
    {
        try{
            $this->roleService()->delete($role);
            return Message::successMessage(trans("message.delete_successfully"));
        }catch(Exception $ex){
            return Message::errorMessage($ex->getMessage());
        }
    }

    /**
     * Permission
     */
    public function permission(RolePermissionRequest $request, Role $role)
    {
        try{
            $this->roleService()->assignPermission($request->permissions, $role);
            return Message::successMessage(trans("message.save_successfully"));
        }catch(Exception $ex){
            return Message::errorMessage($ex->getMessage());
        }
    }

    protected function roleService(){
        return new RoleService();
    }
}
