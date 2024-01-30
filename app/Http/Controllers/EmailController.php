<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\SendMail;

class EmailController extends Controller
{
    public function index()
    {
        // $testMailData = [
        //     'title' => 'Test Email From AllPHPTricks.com',
        //     'body' => 'This is the body of test email.'
        // ];

        // Mail::to('your_email@gmail.com')->send(new SendMail($testMailData));
        
        $message="My name is maxwell";
        $to="amparbengmaxwell@gmail.com";
        $view='emails.testMail';
        $message="Hello team";
        $subjects="Tester";
        email($message,$to,$subjects,$view);
        dd('Success! Email has been sent successfully.');
    }
}