<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->state([
            'first_name' => 'Test',
            'family_name' => 'User',
            'email' => 'paul@rotex1800.de',
        ])->create();

        $event = Event::factory()->state([
            'name' => 'Tour',
        ])->make();

        $role = Role::factory()->state([
            'name' => 'inbound',
        ])->make();

        $user->roles()->save($role);
        $user->events()->save($event);
        $event->roles()->save($role);
    }
}
