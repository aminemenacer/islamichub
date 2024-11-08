<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class SupportController extends Controller
{
    public function index()
    {
        return view('support');
    }

    public function createCheckoutSession(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            // Set the price dynamically based on the amount sent from the frontend
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'gbp',  // Change this if necessary
                            'product_data' => [
                                'name' => 'Donation',
                            ],
                            'unit_amount' => $request->amount * 100,  // Amount in cents
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => route('donation.success'),  // URL on success
                'cancel_url' => route('donation.cancel'),    // URL on cancel
            ]);

            return response()->json(['id' => $session->id]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

}
