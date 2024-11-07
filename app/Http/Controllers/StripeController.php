<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeController extends Controller
{
    public function checkout(Request $request)
    {
        // Map of subscription plans to Stripe Price IDs
        $prices = [
            'basic' => 'price_1QIKJ9Iol4Q5wn4OTTTxBhCn', // Replace with actual price IDs
            'premium' => 'price_1QIKLEIol4Q5wn4OyvlepPK0',
            'deluxe' => 'price_1QIKLwIol4Q5wn4OyDefk5BS',
        ];

        // Get selected plan from request
        $selectedPlan = $request->input('plan');

        if (!$selectedPlan || !array_key_exists($selectedPlan, $prices)) {
            return response()->json(['error' => 'Invalid subscription plan selected.'], 400);
        }

        $priceId = $prices[$selectedPlan];

        try {
            // Set Stripe API key
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            // Create a new checkout session
            $checkoutSession = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price' => $priceId,
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'subscription',
                'success_url' => route('stripe.success'),
                'cancel_url' => route('stripe.cancel'),
            ]);

            // Return the session ID to the frontend
            return response()->json(['sessionId' => $checkoutSession->id]);

        } catch (\Exception $e) {
            // Log error for debugging
            \Log::error('Stripe Checkout session creation failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create checkout session.'], 500);
        }
    }

    public function success()
    {
        return view('stripe.success');
    }

    public function cancel()
    {
        return view('stripe.cancel');
    }
}
