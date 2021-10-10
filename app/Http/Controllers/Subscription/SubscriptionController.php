<?php
declare(strict_types=1);

namespace App\Http\Controllers\Subscription;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionRequest;
use App\Models\Subscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class SubscriptionController
 * @package App\Http\Controllers\Subscription
 */
class SubscriptionController extends Controller
{
    /**
     * Subscribe to a topic
     *
     * @param string $topic
     * @param SubscriptionRequest $request
     * @return JsonResponse
     */
    public function subscribe(string $topic, SubscriptionRequest $request): JsonResponse
    {
        $subscribe = Subscription::updateOrCreate(
            [
                'topic' => $topic,
                'url' => $url = $request->input('url')
            ],
            []
        );

        if (!$subscribe) {
            return response()->json([
                'message' => "An error occurred. Try Again"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'topic' => $topic,
            'url' => $url
        ], Response::HTTP_CREATED);
    }
}
