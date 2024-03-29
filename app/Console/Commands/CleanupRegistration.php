<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\User;
use Illuminate\Console\Command;

class CleanupRegistration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'registration:cleanup-event';

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
        $events = Event::all(['id', 'name'])->toArray();

        if (count($events) == 0) {
            $this->info("There are no events to clean up. You're all good.");

            return;
        }
        $this->question('Which of the following events should be cleaned up?');
        $this->table(['ID', 'Name'], $events, 'box');
        $id = $this->ask('Id of the event to be cleaned up?');

        $this->cleanUpEvent($id);
    }

    private function cleanUpEvent(mixed $id): void
    {
        /** @var Event|null $event */
        $event = Event::find($id);
        if ($event == null) {
            $this->warn("Did not find an event with id '".$id."'");

            return;
        }
        $event->attendees()->each(function ($attendee): bool {
            if ($attendee instanceof User) {
                if ($attendee->events->count() == 1 && ! $attendee->hasRole('rotex')) {
                    $attendee->delete();
                }
            }

            return true;
        });
        $event->delete();
    }
}
