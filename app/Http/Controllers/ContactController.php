<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Mail\ContactFormMail;

class ContactController extends Controller {

    public function index(Request $request) {
        
        $systemMessage = $request->session()->get('system_message');
        
        return view('front.contact.index', [
            'systemMessage' => $systemMessage
        ]);
    }

    public function sendMessage(Request $request) {

        $formData = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'min:50', 'max:500'],
            'g-recaptcha-response' => ['required', 'recaptcha']
        ]);

        \Mail::to('danilo.strahinovic@protonmail.com')->send(new ContactFormMail(
                        $formData['name'],
                        $formData['email'],
                        $formData['message']
        ));

        $request->session()->flash(
                'system_message', 
                'Thank you, contact form is correct. We will contact you as soon as possible!'
                );
        
        return redirect()->route('front.contact.index');
    }

}
