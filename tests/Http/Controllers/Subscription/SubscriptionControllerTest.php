<?php
declare(strict_types=1);

namespace Tests\Http\Controllers\Subscription;

use Illuminate\Http\Response;
use Tests\TestCase;

class SubscriptionControllerTest extends TestCase
{
    public function testSubscribe()
    {
        $payload = [
            "url" => $this->faker->url
        ];
        $topic = $this->faker->firstName;

        $sub = $this->postJson("/subscribe/$topic", $payload);
        $sub->assertCreated();
        $this->assertDatabaseHas('subscriptions', array_merge($payload, ['topic' => $topic]));
    }

    public function testSubscribeValidationFailed()
    {
        $payload = [
            "url" => $this->faker->name
        ];
        $topic = $this->faker->firstName;

        $sub = $this->postJson("/subscribe/$topic", $payload);
        $sub->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
