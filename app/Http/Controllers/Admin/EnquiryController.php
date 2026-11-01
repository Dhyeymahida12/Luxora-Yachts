<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactEnquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EnquiryController extends Controller
{
    public function index(): View
    {
        return view('admin.enquiries.index', [
            'enquiries' => ContactEnquiry::query()
                ->latest('created_at')
                ->latest('id')
                ->paginate(20),
            'statuses' => ['new', 'reviewing', 'replied', 'closed'],
        ]);
    }

    public function update(Request $request, ContactEnquiry $enquiry): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['new', 'reviewing', 'replied', 'closed'])],
        ]);

        $enquiry->update($validated);

        return back()->with('status', 'Enquiry status updated.');
    }
}
