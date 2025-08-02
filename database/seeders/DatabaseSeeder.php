<?php

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\Group;
use App\Models\Message;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'is_admin' => true,
        ]);

        User::factory()->create([
            'name' => 'User',
            'email' => 'user@example.com',
        ]);

        User::factory(10)->create();

        for ($i=0; $i < 5; $i++) {
            $group = Group::factory()->create([
                'owner_id' => 1
            ]);

            $userIds = User::inRandomOrder()->limit(rand(2, 5))->pluck('id');

            $group->users()->attach(array_unique([1, ...$userIds]));
        }

        $users = User::all();
        for ($i = 0; $i < $users->count(); $i++) {
            $user1 = $users->random();
            $user2 = User::where('id', '!=', $user1->id)->inRandomOrder()->first();

            if ($user2) {
                $sortedIds = [$user1->id, $user2->id];
                sort($sortedIds);

                Conversation::firstOrCreate(
                    ['user_id1' => $sortedIds[0], 'user_id2' => $sortedIds[1]]
                );
            }
        }

        Message::factory(1000)->create();
    }
}
