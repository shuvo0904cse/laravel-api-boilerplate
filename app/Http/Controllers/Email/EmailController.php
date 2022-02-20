<?php

namespace App\Http\Controllers\Email;

use App\Helpers\Message;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmailRequest;
use App\Http\Requests\EmailUploadRequest;
use App\Models\Email;
use App\Services\EmailService;
use Exception;
use Illuminate\Http\Request;

class EmailController extends Controller
{
     /**
     * index
     */
    public function index(Request $request)
    {
        try{
            $email = $this->emailService()->lists($request->all());
            return Message::successMessage(trans("message.execute_successfully"), $email->getData());
        }catch(Exception $ex){
            return Message::errorMessage($ex->getMessage());
        }
    }

    /**
     *  Store
     */
    public function store(EmailRequest $request)
    {
        try{
            $email = $this->emailService()->store($request->all());
            return Message::successMessage(trans("message.save_successfully"), $email);
        }catch(Exception $ex){
            return Message::errorMessage($ex->getMessage());
        }
    }

    /**
     * Update
     */
    public function update(EmailRequest $request, Email $email)
    {
        try{
            $email = $this->emailService()->update($request->all(), $email->id);
            return Message::successMessage(trans("message.update_successfully"), $email);
        }catch(Exception $ex){
            return Message::errorMessage($ex->getMessage());
        }
    }

    /**
     * Destroy
     */
    public function destroy(Email $email)
    {
        try{
            $this->emailService()->delete($email);
            return Message::successMessage(trans("message.delete_successfully"));
        }catch(Exception $ex){
            return Message::errorMessage($ex->getMessage());
        }
    }

    /**
     * Upload
     */
    public function upload(EmailUploadRequest $request)
    {
        try{
            $this->emailService()->upload($request->file);
            return Message::successMessage(trans("message.save_successfully"));
        }catch(Exception $ex){
            return Message::errorMessage($ex->getMessage());
        }
    }

    protected function emailService(){
        return new EmailService();
    }
}
