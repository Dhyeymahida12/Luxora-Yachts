<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class AccountController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $enquiries = $user->contactEnquiries()->latest()->get();

        return view('pages.account', compact('user', 'enquiries'));
    }
}
