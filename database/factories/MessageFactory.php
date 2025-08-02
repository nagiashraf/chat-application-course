<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $messageableType = null;
        $messageableId = null;
        $senderId = null;

        if (fake()->boolean(50)) {
            $messageableType = \App\Models\Group::class;
            $messageableId = fake()->randomElement(\App\Models\Group::pluck('id')->toArray());
            $group = \App\Models\Group::find($messageableId);
            $senderId = fake()->randomElement($group->users()->pluck('id')->toArray());
        } else {
            $messageableType = \App\Models\Conversation::class;
            $messageableId = fake()->randomElement(\App\Models\Conversation::pluck('id')->toArray());
            $conversation = \App\Models\Conversation::find($messageableId);
            $senderId = fake()->randomElement([$conversation->user_id1, $conversation->user_id2]);
        }

        return [
            'message' => fake()->realText(200),
            'sender_id' => $senderId,
            'messageable_id' => $messageableId,
            'messageable_type' => $messageableType,
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
