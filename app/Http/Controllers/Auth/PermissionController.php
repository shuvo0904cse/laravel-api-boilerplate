<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Message;
use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use App\Models\Permission;
use App\Services\PermissionService;
use Exception;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * index
     */
    public function index(Request $request)
    {
        try{
            $permission = $this->permissionService()->lists($request->all());
            return Message::successMessage(trans("message.execute_successfully"), $permission->getData());
        }catch(Exception $ex){
            return Message::errorMessage($ex->getMessage());
        }
    }

    /**
     *  Store
     */
    public function store(PermissionRequest $request)
    {
        try{
            $permission = $this->permissionService()->store($request->all());
            return Message::successMessage(trans("message.save_successfully"), $permission->getData());
        }catch(Exception $ex){
            return Message::errorMessage($ex->getMessage());
        }
    }

    /**
     * Update
     */
    public function update(PermissionRequest $request, Permission $permission)
    {
        try{
            $permission = $this->permissionService()->update($request->all(), $permission->id);
            return Message::successMessage(trans("message.save_successfully"), $permission->getData());
        }catch(Exception $ex){
            return Message::errorMessage($ex->getMessage());
        }
    }

    /**
     * Destroy
     */
    public function destroy(Permission $permission)
    {
        try{
            $this->permissionService()->delete($permission);
            return Message::successMessage(trans("message.delete_successfully"));
        }catch(Exception $ex){
            return Message::errorMessage($ex->getMessage());
        }
    }

    protected function permissionService(){
        return new PermissionService();
    }
}
