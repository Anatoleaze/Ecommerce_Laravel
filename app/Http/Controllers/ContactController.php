<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{

    /**
    * Show the home page.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
    public function home()
    {
        $link = config('app.url');

        return view('contact',['link' => $link]);
    }

    public function send(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);
        
        Mail::to('admin@example.com')->send(new ContactMail($validatedData));

        return response()->json(['message' => 'Votre message a été envoyé avec succès!']);
    }
}

