<?php
namespace App\Services;

use App\Helpers\Message;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\SubscriptionCollection;
use App\Jobs\SubscribeMail;
use App\Jobs\SubscriptionMail;
use App\Jobs\UnsubscribeMail;
use App\Jobs\UnSubscriptionMail;
use App\Models\Role;
use App\Models\Subscription;
use Exception;

class SubscriptionService
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
                    "fields"   => ['id', 'email'],
                    "value"    => isset($request['search']) ? $request['search'] : null
                ],
            ];

            //lists
            $subscriptions = $this->subscription()->lists($filter);

            //custom paginate
            $subscription = $this->subscription()->pagination(new SubscriptionCollection($subscriptions->items()), $subscriptions);

            //json response
            return Message::jsonResponse($subscription);
        }catch(Exception $ex){
           Message::throwException($ex);
        }
    }

    /**
     * subscribe
     */
    public function subscribe($request){
        try{
            //store
            $subscribe = $this->store($request);

            //subscribe mail
            SubscriptionMail::dispatch($subscribe);

            return Message::jsonResponse($subscribe);
        }catch(Exception $ex){
           Message::throwException($ex);
        }
    }

    /**
     * un subscribe
     */
    public function unsubscribe($request){
        $email = $this->subscription()->checkEmailAddress($request->email);
        if(empty($email)) Message::throwExceptionMessage(trans("message.email_not_exists"));
        
        try{
             //store
             $subscribe = $this->store($request);

             //unsubscribe mail
             UnSubscriptionMail::dispatch($subscribe);

            //un subscribe mail
            return Message::jsonResponse($subscribe);
        }catch(Exception $ex){
           Message::throwException($ex);
        }
    }

    /**
     * store
     */
    public function store($request){
        try{
            $subscribe = $this->subscription()->create([
                "email" => $request['email']
            ]);
            return Message::jsonResponse($subscribe);
        }catch(Exception $ex){
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
    public function delete($subscription){
        try{
            return $subscription->delete();
        }catch(Exception $ex){
           Message::throwException($ex);
        }
    }


    public function subscription()
    {
        return new Subscription();
    }
}
