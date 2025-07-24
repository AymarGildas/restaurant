<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * Show the About Us page.
     */
    public function about()
    {
        // The $settings variable is already shared globally from AppServiceProvider
        return view('pages.about');
    }

    /**
     * Show the Contact Us page.
     */
    public function contact()
    {
        return view('pages.contact');
    }

    /**
     * Handle the contact form submission.
     */
    public function handleContactForm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // Here, you would typically add logic to send an email to the admin.
        // For now, we will just redirect back with a success message.
        
        return redirect()->route('contact')->with('success', 'Thank you for your message! We will get back to you soon.');
    }
}
