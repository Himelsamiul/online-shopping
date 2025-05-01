<?php

namespace App\Http\Controllers\Backend;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NavbarController extends Controller
{
    public function aboutus()
    {
        return view('frontend.pages.aboutus');
    }

    public function contactus()
    {
        return view('frontend.pages.contact');
    }
public function contactusSubmit(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'numeric', // Only allow numeric phone numbers
            'message' => 'required|string|max:1000',
        ]);


        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone, // Save phone number
            'message' => $request->message,
        ]);

        // Store the contact message in the database
        

        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }



   public function contactusview()
    {
        $contacts = Contact::latest()->get();
        return view('backend.pages.list', compact('contacts'));

   
    }

    public function destroy($id)
    {
        Contact::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Contact message deleted successfully.');
    }
}
