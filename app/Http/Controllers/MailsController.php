<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class MailsController extends Controller
{
    public function welcomeMail()
    {
        Mail::to ('diyanahrahim97@gmail.com')->send (new WelcomeMail());

        return 'email sent successfully';
    }
}
