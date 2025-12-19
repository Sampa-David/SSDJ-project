<?php

namespace App\Http\Controllers;

use App\Models\EventPublishingRight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventPaymentController extends Controller
{
    /**
     * Show the event publishing payment page
     */
    public function showPaymentPage()
    {
        $packages = EventPublishingRight::getPackages();
        $userHasRights = Auth::user()->hasActivePublishingRights();
        $activeRight = Auth::user()->getActivePublishingRight();
        
        return view('events.payment', compact('packages', 'userHasRights', 'activeRight'));
    }

    /**
     * Process payment for event publishing rights
     */
    public function processPayment(Request $request)
    {
        $request->validate([
            'package_type' => 'required|in:monthly,quarterly,yearly',
        ]);

        $packages = EventPublishingRight::getPackages();
        $packageType = $request->package_type;
        
        if (!isset($packages[$packageType])) {
            return back()->withErrors(['package_type' => 'Invalid package type']);
        }

        $package = $packages[$packageType];
        $price = $package['price'];

        try {
            // Create publishing right
            $publishingRight = EventPublishingRight::create([
                'user_id' => Auth::id(),
                'package_type' => $packageType,
                'price' => $price,
                'status' => 'active',
                'purchased_at' => now(),
                'expires_at' => now()->addDays($package['duration']),
                'payment_id' => 'PAY_' . uniqid(),
            ]);

            return redirect()
                ->route('events.payment-confirmation', $publishingRight->id)
                ->with('success', 'Paiement effectué avec succès!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erreur lors du traitement du paiement']);
        }
    }

    /**
     * Show payment confirmation page
     */
    public function confirmation(EventPublishingRight $publishingRight)
    {
        // Ensure user can only see their own publishing rights
        if ($publishingRight->user_id !== Auth::id()) {
            abort(403);
        }

        $package = EventPublishingRight::getPackages()[$publishingRight->package_type];
        return view('events.payment-confirmation', compact('publishingRight', 'package'));
    }
}
