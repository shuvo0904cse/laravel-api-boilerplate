<?php
namespace App\Services;

use App\Helpers\Message;
use App\Http\Resources\ContactCollection;
use App\Http\Resources\ContactResource;
use App\Http\Resources\RoleCollection;
use App\Jobs\ContactConfirmation;
use App\Jobs\ContactReply;
use App\Models\Contact;
use App\Models\Role;
use Exception;

class ContactService
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
                    "fields"   => ['id', 'first_name', 'last_name', 'email', 'subject', 'message'],
                    "value"    => isset($request['search']) ? $request['search'] : null
                ]
            ];

            //lists
            $contacts = $this->contactModel()->lists($filter);

            //custom paginate
            $contact = $this->contactModel()->pagination(new ContactCollection($contacts->items()), $contacts);

            //json response
            return Message::jsonResponse($contact);
        }catch(Exception $ex){
           Message::throwException($ex);
        }
    }

    /**
     * delete
     */
    public function delete($contact){
        try{
            return $contact->delete();
        }catch(Exception $ex){
           Message::throwException($ex);
        }
    }

    /**
     * contact
     */
    public function contact($request){
        try{
            //store contact
            $contact = $this->storeContact($request);

            //send confirmation mail
            ContactConfirmation::dispatch($contact);

            //send reply mail
            ContactReply::dispatch($contact);
  
            return Message::jsonResponse(new ContactResource($contact));
        }catch(Exception $ex){
           Message::throwException($ex);
        }
    }

    /**
     * Store Contact
     */
    public function storeContact($request){
        try{
            return $this->contactModel()->create([
                "first_name"    => $request['first_name'],
                "last_name"     => $request['last_name'],
                "email"         => $request['email'],
                "subject"       => $request['subject'],
                "message"       => $request['message']
            ]);
        }catch(Exception $ex){
           Message::throwException($ex);
        }
    }


    public function contactModel()
    {
        return new Contact();
    }
}
