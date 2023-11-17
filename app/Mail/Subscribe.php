<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Subscribe extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user_name,$randomNumber;

    public function __construct($user_name,$randomNumber)
    {
        $this->user_name = $user_name;
        $this->randomNumber = $randomNumber;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('OTP for Changing Password')
        ->markdown('emails.subscribers');
    }
}
