<?php
namespace App\Services;

use App\Helpers\Message;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\UserCollection;
use App\Models\Role;
use App\Models\User;
use Exception;

class UserService
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
                "relation"     => ['userDetail', 'roles', 'permissions'] 
            ];

            //lists
            $users = $this->user()->lists($filter);

            //custom paginate
            $user = $this->user()->pagination(new UserCollection($users->items()), $users);

            //json response
            return Message::jsonResponse($user);
        }catch(Exception $ex){
           Message::throwException($ex);
        }
    }

    /**
     * store
     */
    public function store($request){
        try{
            //user store

            //user details store

            //user roles
            $role = $this->user()->create([
                "first_name" => $request['first_name'],
                "last_name" => $request['last_name'],
                "email" => $request['email'],
                "type" => config("settings.role_optional")
            ]);
            return Message::jsonResponse($role);
        }catch(Exception $ex){
           Message::throwException($ex);
        }
    }
    
    /**
     * update
     */
    public function update($request, $roleId){
        try{
            $role = $this->user()->where("id", $roleId)->update([
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
    public function delete($user){
        try{
            return $user->delete();
        }catch(Exception $ex){
           Message::throwException($ex);
        }
    }

    /**
     * assign permission
     */
    public function assignPermission($permissions, $user){
        try{
            return $user->permissions()->sync($permissions);
        }catch(Exception $ex){
           Message::throwException($ex);
        }
    }

     /**
     * assign role
     */
    public function assignRole($roles, $user){
        try{
            return $user->permissions()->sync($roles);
        }catch(Exception $ex){
           Message::throwException($ex);
        }
    }


    public function user()
    {
        return new User();
    }
}
