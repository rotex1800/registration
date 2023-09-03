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
    public function handle()
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
        $event = Event::find($id);
        $event->attendees()->each(function (User $attendee) {
            if ($attendee->events->count() == 1) {
                $attendee->delete();
            }
        });
        $event->delete();
    }
}
