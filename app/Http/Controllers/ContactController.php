<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    //
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);
        // Store the contact message in the database
        Contact::create($data);
        // Optionally, you can send an email notification here
        // Redirect back with a success message 
        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
}
