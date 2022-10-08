<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Role;
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
        if (Role::where('name', 'rotex')->count() == 0) {
            Role::factory()->rotex()->create();
        }

        if (Role::where('name', 'participant')->count() == 0) {
            Role::factory()->participant()->create();
        }

        if (Event::where('name', 'Deutschland Tour')->count() == 0) {
            Event::factory()->state([
                'name' => 'Deutschland Tour',
                'start' => '2023-03-22',
                'end' => '2023-04-08',
            ])->create();
        }
    }
}
