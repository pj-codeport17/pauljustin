<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller {

    public function show() {
        return view('user.contact');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        Contact::create($data);

        return redirect()->route('contact')
            ->with('success', "Message sent! We'll get back to you soon.");
    }
}
