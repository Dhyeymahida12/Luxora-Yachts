<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscription;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class NewsletterController extends Controller
{
    public function index(): View
    {
        return view('admin.newsletter.index', [
            'subscriptions' => NewsletterSubscription::query()
                ->latest('created_at')
                ->latest('id')
                ->paginate(50),
        ]);
    }

    public function export(): StreamedResponse
    {
        return response()->streamDownload(function (): void {
            $output = fopen('php://output', 'w');
            fputcsv($output, ['Email', 'Subscribed at']);

            NewsletterSubscription::query()
                ->orderBy('id')
                ->chunkById(500, function ($subscriptions) use ($output): void {
                    foreach ($subscriptions as $subscription) {
                        fputcsv($output, [
                            $subscription->email,
                            $subscription->created_at?->toIso8601String(),
                        ]);
                    }
                });

            fclose($output);
        }, 'luxora-newsletter-subscribers.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
