<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($member,$url)
    {
        //
        $this->member = $member;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
//        dd('メールをbuild!');
        $result =  $this->from('taichi.01gr14@gmail.com')->to($this->member->email)->view('emails.reset_password',[
            'url'=> $this->url
        ]);
        return $result;
    }
}
