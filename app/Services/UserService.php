<?php
namespace App\Services;

use App\Helpers\Message;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\UserCollection;
use App\Models\Role;
use App\Models\User;
use App\Models\UserDetail;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
                    "fields"   => ['id', 'first_name', 'last_name', 'email',],
                    "value"    => isset($request['search']) ? $request['search'] : null
                ],
                //"relation"     => ['userDetail', 'roles', 'permissions'] 
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
        DB::beginTransaction();
        try{
            //user store
            $user = $this->storeUser($request);

            //user details store
            $this->storeUserDetails($request, $user->id);

            //user roles
            $this->assignRole($request['roles'], $user);

            DB::commit();
            return Message::jsonResponse($user);
        }catch(Exception $ex){
            dd($ex->getMessage());
           DB::rollBack(); 
           Message::throwException($ex);
        }
    }

    /**
     * store user
     */
    protected function storeUser($request){
        try{
            return $this->user()->create([
                "first_name"        => $request['first_name'],
                "last_name"         => $request['last_name'],
                "email"             => $request['email'],
                "email_verified_at" => now(),
                "password"          => bcrypt($request['password']),
            ]);
        }catch(Exception $ex){
           Message::throwException($ex);
        }
    }

    /**
     * store user Details
     */
    protected function storeUserDetails($request, $userId){
        try{
            return $this->userDetail()->create([
                "user_id"         => $userId,
                "contact_number"  => $request['contact_number'],
                "dob"             => $request['dob'],
                "country"         => $request['country'],
                "state"           => $request['state'],
                "zip_code"        => $request['zip_code'],
                "address_1"       => $request['address_1'],
                "address_2"       => $request['address_2'],
                "speciality"      => $request['speciality'],
                "experience"      => $request['experience'],
                "web_link"        => $request['web_link'],
            ]);
        }catch(Exception $ex){
           Message::throwException($ex);
        }
    }
    
    /**
     * update
     */
    public function update($request, $user){
        DB::beginTransaction();
        try{
            //user update
            $this->updateUser($request, $user->id);

            //user details update
            $this->updateUserDetails($request, $user->id);

            //user roles
            $this->assignRole($request['roles'], $user);

            DB::commit();
            return Message::jsonResponse($user);
        }catch(Exception $ex){
           DB::rollBack(); 
           Message::throwException($ex);
        }
    }

    /**
     * update user
     */
    protected function updateUser($request, $userId){
        try{
            return $this->user()->where("id", $userId)->update([
                "first_name"        => $request['first_name'],
                "last_name"         => $request['last_name'],
                "email"             => $request['email'],
                "email_verified_at" => now()
            ]);
        }catch(Exception $ex){
           Message::throwException($ex);
        }
    }

    /**
     * update user Details
     */
    protected function updateUserDetails($request, $userId){
        try{
            return $this->userDetail()->where("user_id", $userId)->update([
                "contact_number"  => $request['contact_number'],
                "dob"             => $request['dob'],
                "country"         => $request['country'],
                "state"           => $request['state'],
                "zip_code"        => $request['zip_code'],
                "address_1"       => $request['address_1'],
                "address_2"       => $request['address_2'],
                "speciality"      => $request['speciality'],
                "experience"      => $request['experience'],
                "web_link"        => $request['web_link'],
            ]);
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
            return $user->roles()->sync($roles);
        }catch(Exception $ex){
           Message::throwException($ex);
        }
    }


    public function user()
    {
        return new User();
    }

    public function userDetail()
    {
        return new UserDetail();
    }
}
