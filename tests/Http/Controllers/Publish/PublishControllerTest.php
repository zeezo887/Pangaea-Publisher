<?php
declare(strict_types=1);

namespace Tests\Http\Controllers\Publish;

use App\Models\Subscription;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PublishControllerTest extends TestCase
{
    public function testPublish()
    {
        $sub = Subscription::factory()->create();

        Http::fake();
        $pub = $this->postJson("/publish/{$sub->topic}", ['message' => 'Hello']);

        $pub->assertOk();
    }

    public function testPublishNoBody()
    {
        $sub = Subscription::factory()->create();

        Http::fake();
        $pub = $this->postJson("/publish/{$sub->topic}");

        $pub->assertStatus(Response::HTTP_BAD_REQUEST);
    }
}
