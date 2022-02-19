<?php

namespace App\Exceptions;

use App\Helpers\Message;
use App\Mail\ExceptionOccured;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

     /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function render($request, Throwable $exception)
    {
        if($exception instanceof ModelNotFoundException){
            return Message::errorMessage("Data Not Found");
        }
        return parent::render($request, $exception);
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $exception) {
            $this->sendEmail($exception);
        });

        $this->renderable(function (Throwable $exception) {
            return Message::errorMessage($exception->getMessage());
        });
    }

    /**
     * Send Email
     */
    public function sendEmail(Throwable $exception)
    {
       try {
           $exceptions = [
               "message"    => $exception->getMessage(),
               "file_name"  => $exception->getFile(),
               "line_number"=> $exception->getLine()
           ];
           Mail::to('shuvo0904@gmail.com')->send(new ExceptionOccured($exceptions));
        } catch (Throwable $exception) {
            Log::error($exception);
        }
    }
 
}
