<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
      return view('contact');
    }

    public function submit(Request $request)
    {
       $validated = $request->validate([
        'first_name' => 'required|string|max:120',
        'last_name' => 'required|string|max:120',
        'email' => 'required|email',
        'userMessage' => 'required|string|max:3000'
       ]);

       $data = [
         'name' => $validated['first_name'] . '' . $validated['last_name'],
         'email' => $validated['email'],
         'message' => $validated['message']
       ];

       Mail::send('emails.contact', $data, function ($msg) use ($data) {
          $msg->to('adebesinnewton99@gmail.com')
              ->subject('New Contact Message from ' . $data['name']);
       });
       return back()->with('success', 'Your message has been sent successfully');
    }
}

