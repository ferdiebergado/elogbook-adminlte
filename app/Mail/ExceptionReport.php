<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Exception;
use Whoops\Run as Whoops;
use Whoops\Handler\PrettyPageHandler as Handler;

class ExceptionReport extends Mailable
{
    use Queueable, SerializesModels;
    private $exception;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($exception)
    {
        $this->exception = $exception;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $whoops = new Whoops();
        $whoops->allowQuit(false);
        $whoops->writeToOutput(false);
        $whoops->pushHandler(new Handler());
        $body = $whoops->handleException($this->exception);  
        return $this->view('mail.exceptionreport')->with([
            'body' => $body
        ]);
    }
}
