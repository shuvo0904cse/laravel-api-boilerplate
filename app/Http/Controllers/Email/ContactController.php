<?php

namespace App\Http\Controllers\Email;

use App\Helpers\Message;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Services\ContactService;
use Exception;
use Illuminate\Http\Request;

class ContactController extends Controller
{
     /**
     * index
     */
    public function index(Request $request)
    {
        try{
            $contact = $this->contactService()->lists($request->all());
            return Message::successMessage(trans("message.execute_successfully"), $contact->getData());
        }catch(Exception $ex){
            dd($ex->getMessage());
            return Message::errorMessage($ex->getMessage());
        }
    }

    /**
     * show
     */
    public function show(Contact $contact)
    {
        try{
            return Message::successMessage(trans("message.execute_successfully"), $contact);
        }catch(Exception $ex){
            return Message::errorMessage($ex->getMessage());
        }
    }

    /**
     * Destroy
     */
    public function destroy(Contact $contact)
    {
        try{
            $this->contactService()->delete($contact);
            return Message::successMessage(trans("message.delete_successfully"));
        }catch(Exception $ex){
            return Message::errorMessage($ex->getMessage());
        }
    }

    /**
     * Contact
     */
    public function contact(ContactRequest $request)
    {
        try{
            $contact = $this->contactService()->contact($request->all());
            return Message::successMessage(trans("message.save_successfully"),  $contact->getData());
        }catch(Exception $ex){
            return Message::errorMessage($ex->getMessage());
        }
    }

    protected function contactService(){
        return new ContactService();
    }
}
