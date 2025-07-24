<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
        public function __construct()
    {
        // examples:
        $this->middleware(['permission:site-settings-list'],["only" =>["index","show"]]);
        $this->middleware(['permission:site-settings-edit'],["only" =>["edit","update"]]);
      
    }
    public function index()
    {
        $settings = SiteSetting::first();
        return view('admin.settings.index', compact('settings'));
    }

    public function edit()
    {
        $settings = SiteSetting::firstOrCreate(['id' => 1]);
        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        // 1. Add validation for all the new footer fields
        $validated = $request->validate([
            'site_name'            => 'nullable|string|max:255',
            'primary_color'        => 'nullable|string|max:20',
            'secondary_color'      => 'nullable|string|max:20',
            'contact_email'        => 'nullable|email|max:255',
            'phone_number'         => 'nullable|string|max:30',
            'payment_info'         => 'nullable|string',
            'footer_address'       => 'nullable|string|max:255',
            'footer_about_text'    => 'nullable|string',
            'social_facebook_url'  => 'nullable|url|max:255',
            'social_instagram_url' => 'nullable|url|max:255',
            'social_twitter_url'   => 'nullable|url|max:255',
        ]);

        $settings = SiteSetting::firstOrCreate(['id' => 1]);
        $settings->update($validated);

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }
}
