<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CreateEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'registration:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $name = $this->ask('What is the name of the event?');
        /** @var string $startDateInput */
        $startDateInput = $this->ask('When does it start?');
        $start = Carbon::parse($startDateInput);
        /** @var string $endDateInput */
        $endDateInput = $this->ask('When does it end?');
        $end = Carbon::parse($endDateInput);
        $event = Event::factory()->create([
            'name' => $name,
            'start' => $start,
            'end' => $end,
        ]);
        $this->assignRolesToEvent($event);
    }

    private function assignRolesToEvent(Event $event): void
    {
        $roles = $this->choice(
            'Who is the target audience of the event?',
            Role::all()->map(fn (Role $role) => $role->name)->toArray(),
            multiple: true
        );
        if (is_array($roles)) {
            foreach ($roles as $role) {
                $event->giveRole($role);
            }
        } else {
            $event->giveRole($roles);
        }
    }
}
