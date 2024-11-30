<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Services\OLXParserService;
use Illuminate\Http\Request;

class PriceTrackerController extends Controller
{
    protected $olxParserService;

    public function __construct(OLXParserService $olxParserService)
    {
        $this->olxParserService = $olxParserService;
    }

    public function trackPrice(Request $request)
    {
        $request->validate([
            'ad_url' => 'required|url',
            'email' => 'required|email',
        ]);

        $price = $this->olxParserService->getPriceFromUrl($request->input('ad_url'));

        if ($price !== null) {
            $subscription = Subscription::where('ad_url', $request->input('ad_url'))->first();

            if (!$subscription) {
                Subscription::create([
                    'ad_url' => $request->input('ad_url'),
                    'email' => $request->input('email'),
                    'last_price' => $price,
                ]);
            }

            return response()->json(['message' => 'Subscribed successfully'], 200);
        }

        return response()->json(['message' => 'Subscribe can be complete, try again'], 400);
    }
}
