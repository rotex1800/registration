<?php

namespace App\Console\Commands;

use App\Models\Event;
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
    public function handle()
    {
        $name = $this->ask('What is the name of the event?');
        $start = Carbon::parse($this->ask('When does it start?'));
        $end = Carbon::parse($this->ask('When does it end?'));
        Event::factory()->create([
            'name' => $name,
            'start' => $start,
            'end' => $end
        ]);
    }
}
