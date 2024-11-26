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
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $planDetails = [
            'basic' => [
                'price_data' => [
                    'currency' => 'gbp',
                    'product_data' => [
                        'name' => 'Basic Plan',
                    ],
                    'unit_amount' => 200, // Amount in cents ($2)
                ],
            ],
            'premium' => [
                'price_data' => [
                    'currency' => 'gbp',
                    'product_data' => [
                        'name' => 'Premium Plan',
                    ],
                    'unit_amount' => 400, // Amount in cents ($4)
                ],
            ],
            'deluxe' => [
                'price_data' => [
                    'currency' => 'gbp',
                    'product_data' => [
                        'name' => 'Deluxe Plan',
                    ],
                    'unit_amount' => 600, // Amount in cents ($6)
                ],
            ],
        ];

        $plan = $request->input('plan'); // 'basic', 'premium', or 'deluxe'

        if (!isset($planDetails[$plan])) {
            return response()->json(['error' => 'Invalid plan'], 400);
        }

        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => $planDetails[$plan]['price_data'],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('donation.success'), // Link to success route
                'cancel_url' => route('donation.cancel'),   // Link to cancel route
            ]);

            return response()->json(['sessionId' => $session->id]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}