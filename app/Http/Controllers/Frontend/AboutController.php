<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AboutController extends Controller
{
     public function about_us()
    {
        $page = StaticPage::findBySlug('about-us');
        return view('frontend.about', compact('page'));
    }

    public function why_us()
    {
        $page = StaticPage::findBySlug('why-us');
        return view('frontend.why-us', compact('page'));
    }

    public function chat_with_us()
    {
        $page = StaticPage::findBySlug('chat-with-us');
        return view('frontend.chat-with-us', compact('page'));
    }

    public function animal_welfare()
    {
        $page = StaticPage::findBySlug('animal-welfare');
        return view('frontend.animal-welfare', compact('page'));
    }

    public function contact_store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name'    => 'required|string|max:60',
        'email'   => 'required|email|max:100',
        'subject' => 'required|string|max:100',
        'message' => 'required|string|max:800',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors'  => $validator->errors(),
        ], 422);
    }

    // Store in DB (optional — see step 3)
    \App\Models\ContactMessage::create([
        'name'    => $request->name,
        'email'   => $request->email,
        'subject' => $request->subject,
        'message' => $request->message,
    ]);

    // Send email notification (optional — see step 4)
    // Mail::to(config('mail.from.address'))->send(new \App\Mail\ContactReceived($request->all()));

    return response()->json([
        'success' => true,
        'message' => 'Message received! We\'ll get back to you within 24 hours.',
    ]);
}
}
