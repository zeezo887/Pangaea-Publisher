<?php
declare(strict_types=1);

namespace App\Http\Services;

use App\Http\Interfaces\RequestInterface;
use Illuminate\Support\Facades\Http;

class HttpService implements RequestInterface
{
    public function sendToMany(array $body, array $urls = []): array
    {
        $success = $failed = [];
        foreach ($urls as $subscriber) {
            try {
                $response = Http::accept('application/json')
                    ->withHeaders(['Content-Type' => 'application/json'])
                    ->post($subscriber, $body);

                if ($response->ok()) {
                    $success[] = $subscriber;
                } else {
                    $response->throw();
                }
            } catch (\Exception $e) {
                $failed[] = [
                    'url' => $subscriber,
                    'message' => $e->getMessage()
                ];
            }
        }

        return [$success, $failed];
    }
}
