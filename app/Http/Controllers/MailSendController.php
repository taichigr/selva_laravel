<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MailSendController extends Controller
{
    //
    public function send(){

        $data = [];

        Mail::send('emails.test', $data, function($message){
            $message->to('taichan_yade@yahoo.co.jp', 'Test')->subject('This is a test mail');
    	});
    }
}
