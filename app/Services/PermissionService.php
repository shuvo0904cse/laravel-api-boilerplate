<?php
namespace App\Services;

use App\Helpers\Message;
use App\Http\Resources\PermissionCollection;
use App\Http\Resources\RoleCollection;
use App\Models\Permission; 
use Exception;

class PermissionService
{
    /**
     * lists
     */
    public function lists($request){
        try{
            //filter
            $filter = [
                "is_paginate"  => true,
                "search"       => [
                    "fields"   => ['id', 'name'],
                    "value"    => isset($request['search']) ? $request['search'] : null
                ],
                "relation" => ["roles"]
            ];

            //lists
            $permissions = $this->permission()->lists($filter);

            //custom paginate
            $permission = $this->permission()->pagination(new PermissionCollection($permissions->items()), $permissions);

            //json response
            return Message::jsonResponse($permission);
        }catch(Exception $ex){
            dd($ex->getMessage());
           Message::throwException($ex);
        }
    }

    /**
     * store
     */
    public function store($permission){
        try{
            $permission = $this->permission()->create([
                "name"      => $permission['name'],
                "route"     => $permission['route'],
                "details"   => $permission['details'],
                "type"      => $permission['type']
            ]);
            return Message::jsonResponse($permission);
        }catch(Exception $ex){
           Message::throwException($ex);
        }
    }
    
    /**
     * update
     */
    public function update($permission, $permissionId){
        try{
            $permission = $this->permission()->where("id", $permissionId)->update([
                "name"      => $permission['name'],
                "route"     => $permission['route'],
                "details"   => $permission['details'],
                "type"      => $permission['type']
            ]);
            return Message::jsonResponse($permission);
        }catch(Exception $ex){
           Message::throwException($ex);
        }
    }

    /**
     * delete
     */
    public function delete($permission){
        try{
            return $permission->delete();
        }catch(Exception $ex){
           Message::throwException($ex);
        }
    }


    public function permission()
    {
        return new Permission();
    }
}
