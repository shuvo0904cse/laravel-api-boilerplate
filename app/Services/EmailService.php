<?php
namespace App\Services;

use App\Helpers\Message;
use App\Http\Resources\EmailCollection;
use App\Http\Resources\RoleCollection;
use App\Jobs\EmailCsvProcess;
use App\Models\Email;
use App\Models\Role;
use Exception;
use Illuminate\Support\Facades\Bus;

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
                    "fields"   => ['id', 'name', 'email'],
                    "value"    => isset($request['search']) ? $request['search'] : null
                ]
            ];
            
            //lists
            $emails = $this->email()->lists($filter);

            //custom paginate
            $email = $this->email()->pagination(new EmailCollection($emails->items()), $emails);

            //json response
            return Message::jsonResponse($email);
        }catch(Exception $ex){
           Message::throwException($ex);
        }
    }

    /**
     * store
     */
    public function store($request){
        try{
            return $this->email()->create([
                "name" => $request['name'],
                "email" => $request['email']
            ]);
        }catch(Exception $ex){
           Message::throwException($ex);
        }
    }
    
    /**
     * update
     */
    public function update($request, $emailId){
        try{
            return $this->email()->where("id", $emailId)->update([
                "name" => $request['name'],
                "email" => $request['email']
            ]);
        }catch(Exception $ex){
           Message::throwException($ex);
        }
    }

    /**
     * delete
     */
    public function delete($email){
        try{
            return $email->delete();
        }catch(Exception $ex){
           Message::throwException($ex);
        }
    }

    /**
     * assign permission
     */
    public function upload($file){
        try{
           //get file
           $data = file($file);

           // Chunking file
           $chunks = array_chunk($data, 500);
           
           //Bus batching
           $header = [];
           $newBatch  = Bus::batch([])->dispatch();
           
           foreach ($chunks as $key => $chunk) {
               $data = array_map('str_getcsv', $chunk);
               
               if ($key === 0) {
                   $header = $data[0];
                   unset($data[0]);
               }
               
               //email csv process and add in bus batch
               $newBatch->add(new EmailCsvProcess($data, $header));
           }
           return $newBatch;
        }catch(Exception $ex){
           Message::throwException($ex);
        }
    }


    public function email()
    {
        return new Email();
    }
}
