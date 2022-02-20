<?php
namespace App\Services;

use App\Helpers\Message;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\SubscriptionCollection;
use App\Http\Resources\SubscriptionResource;
use App\Http\Resources\UnsubscriptionResource;
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
            $subscribe = $this->storeSubscribe($request);
            
            //subscribe mail
            SubscriptionMail::dispatch($subscribe);

            return Message::jsonResponse(new SubscriptionResource($subscribe));
        }catch(Exception $ex){
           Message::throwException($ex);
        }
    }

    /**
     * un subscribe
     */
    public function unsubscribe($request){
        $unsubscribeEmail = $this->subscription()->checkSubscribedEmailAddress($request['email']);
        if(empty($unsubscribeEmail)) Message::throwExceptionMessage(trans("message.email_not_exists"));
        
        try{
             //Delete Subscribed Email
             $this->deleteSubscribedEmail($unsubscribeEmail->id);

             //unsubscribe mail
             UnSubscriptionMail::dispatch($unsubscribeEmail);

            //un subscribe mail
            return Message::jsonResponse(new UnsubscriptionResource($unsubscribeEmail));
        }catch(Exception $ex){
           Message::throwException($ex);
        }
    }

    /**
     * store Subscribe
     */
    public function storeSubscribe($request){
        try{
            $subscribe = $this->subscription()->create([
                "email" => $request['email']
            ]);
            return $subscribe;
        }catch(Exception $ex){
           Message::throwException($ex);
        }
    }
    
    /**
     * update UnSubscribe
     */
    public function deleteSubscribedEmail($subscriptionId){
        try{
            return $this->subscription()->where("id", $subscriptionId)->delete();
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
