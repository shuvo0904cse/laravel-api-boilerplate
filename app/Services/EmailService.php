<?php
namespace App\Services;

use App\Helpers\Message;
use App\Http\Resources\RoleCollection;
use App\Models\Role;
use Exception;

class EmailService
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
                "relation" => ['permissions']
            ];

            //lists
            $roles = $this->role()->lists($filter);

            //custom paginate
            $role = $this->role()->pagination(new RoleCollection($roles->items()), $roles);

            //json response
            return Message::jsonResponse($role);
        }catch(Exception $ex){
           Message::throwException($ex);
        }
    }

    /**
     * store
     */
    public function store($request){
        try{
            $role = $this->role()->create([
                "name" => $request['name'],
                "type" => config("settings.role_optional")
            ]);
            return Message::jsonResponse($role);
        }catch(Exception $ex){
            dd($ex->getMessage());
           Message::throwException($ex);
        }
    }
    
    /**
     * update
     */
    public function update($request, $roleId){
        try{
            $role = $this->role()->where("id", $roleId)->update([
                "name"  => $request['name']
            ]);
            return Message::jsonResponse($role);
        }catch(Exception $ex){
           Message::throwException($ex);
        }
    }

    /**
     * delete
     */
    public function delete($role){
        try{
            return $role->delete();
        }catch(Exception $ex){
           Message::throwException($ex);
        }
    }

    /**
     * assign permission
     */
    public function assignPermission($permissions, $role){
        try{
            return $role->permissions()->sync($permissions);
        }catch(Exception $ex){
           Message::throwException($ex);
        }
    }


    public function role()
    {
        return new Role();
    }
}
