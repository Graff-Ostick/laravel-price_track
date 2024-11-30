<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Subscription;
// TODO if impossible to get price from api delete this
class SubscriptionController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function subscribe(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'url' => 'required|url',
            'email' => 'required|email',
        ]);

        $existingSubscription = Subscription::where('url', $validated['url'])
            ->where('email', $validated['email'])
            ->first();

        if ($existingSubscription) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are already subscribed to this advertisement.',
            ], 400);
        }

        $subscription = Subscription::create([
            'email' => $validated['email'],
            'url' => $validated['url'],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Subscription added successfully.',
            'data' => $subscription,
        ], 201);
    }
}
