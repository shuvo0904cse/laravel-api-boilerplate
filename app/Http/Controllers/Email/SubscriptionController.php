<?php

namespace App\Http\Controllers\Email;

use App\Helpers\Message;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionRequest;
use App\Http\Requests\UnSubscriptionRequest;
use App\Services\SubscriptionService;
use Exception;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
     /**
     * index
     */
    public function index(Request $request)
    {
        try{
            $subscription = $this->subscriptionService()->lists($request->all());
            return Message::successMessage(trans("message.execute_successfully"), $subscription->getData());
        }catch(Exception $ex){
            return Message::errorMessage($ex->getMessage());
        }
    }

     /**
     *  Subscribe
     */
    public function subscribe(SubscriptionRequest $request)
    {
        try{
            $subscription = $this->subscriptionService()->subscribe($request->all());
            return Message::successMessage(trans("message.execute_successfully"), $subscription->getData());
        }catch(Exception $ex){
            return Message::errorMessage($ex->getMessage());
        }
    }

    /**
     *  Un Subscribe
     */
    public function unSubscribe(UnSubscriptionRequest $request)
    {
        try{
            $subscription = $this->subscriptionService()->unsubscribe($request->all());
            return Message::successMessage(trans("message.execute_successfully"), $subscription->getData());
        }catch(Exception $ex){
            return Message::errorMessage($ex->getMessage());
        }
    }

    protected function subscriptionService(){
        return new SubscriptionService();
    }
}
