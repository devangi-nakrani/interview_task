<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ShortUrlController extends Controller
{
    // 1. Dashbord  Links 
    public function index()
    {
        $user = Auth::user();
        $role = strtolower($user->role);

        if ($role == 'superadmin') {
            $shortUrls = ShortUrl::latest()->get(); // all showing links
        } elseif ($role == 'admin') {
            $shortUrls = ShortUrl::where('company_id', $user->company_id)->latest()->get(); // only company showing
        } else {
            $shortUrls = ShortUrl::where('user_id', $user->id)->latest()->get(); // only user showing
        }

        return view('dashboard', compact('shortUrls'));
    }

    // 2. new Short Link 
    public function store(Request $request)
    {
        $user = Auth::user();

        if (strtolower($user->role) == 'superadmin') {
            return back()->with('error', 'SuperAdmin cannot create links.');
        }

        $request->validate(['original_url' => 'required|url']);

        ShortUrl::create([
            'original_url' => $request->original_url,
            'short_code' => Str::random(6),
            'user_id' => $user->id,
            'company_id' => $user->company_id,
        ]);

        return back()->with('success', 'URL shortened successfully!');
    }

    // 3. Short Link 
    public function resolve($code)
    {
        $url = ShortUrl::where('short_code', $code)->firstOrFail();
        return redirect()->away($url->original_url);
    }
}
