<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class AssignRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'registration:assign {role?} {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign a role to a user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $role = strval($this->argument('role'));
        if ($role == null) {
            $role = $this->ask("What's the name of the role?");
        }

        $email = strval($this->argument('email'));
        if ($email == null) {
            $email = $this->ask("What's the email of the user?");
        }

        $user = User::where('email', $email)->first();
        if ($user == null) {
            $this->error("There is no user with email '".$email."'");

            return Command::FAILURE;
        }
        $this->info("Assigning role '".$role."' to user with email '".$email."'");
        $user->giveRole("".$role);

        return Command::SUCCESS;
    }
}
