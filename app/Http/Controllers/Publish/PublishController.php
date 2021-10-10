<?php
declare(strict_types=1);

namespace App\Http\Controllers\Publish;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\RequestInterface;
use App\Models\Subscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class PublishController
 * @package App\Http\Controllers\Publish
 */
class PublishController extends Controller
{
    /**
     * PublishController constructor.
     * @param RequestInterface $request
     */
    public function __construct(private RequestInterface $request)
    {}

    /**
     * Publish message to topic
     *
     * @param string $topic
     * @return JsonResponse
     */
    public function publish(string $topic): JsonResponse
    {
        // Check if data is not empty
        $data = request()->post();
        if (count($data) == 0) {
            return response()->json([
                'message' => 'Request body cannot be empty'
            ], Response::HTTP_BAD_REQUEST);
        }

        $subscribers = Subscription::where('topic', $topic)->pluck('url')->toArray();

        $body = [
            'topic' => $topic,
            'data' => $data
        ];

        [$success, $failed] = $this->request->sendToMany($body, $subscribers);

        return response()->json([
            'success' => $success,
            'failed' => $failed
        ], count($failed) > 0 ? Response::HTTP_INTERNAL_SERVER_ERROR : Response::HTTP_OK);
    }
}
