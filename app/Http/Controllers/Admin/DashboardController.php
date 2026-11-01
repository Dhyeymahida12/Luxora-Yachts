<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactEnquiry;
use App\Models\NewsletterSubscription;
use App\Models\Yacht;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'yachtCount' => Yacht::query()->count(),
            'publishedYachtCount' => Yacht::query()->where('is_published', true)->count(),
            'newEnquiryCount' => ContactEnquiry::query()->where('status', 'new')->count(),
            'enquiryCount' => ContactEnquiry::query()->count(),
            'subscriberCount' => NewsletterSubscription::query()->count(),
            'recentEnquiries' => ContactEnquiry::query()->latest()->limit(5)->get(),
        ]);
    }
}
