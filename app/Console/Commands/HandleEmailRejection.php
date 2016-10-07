<?php

namespace Matchappen\Console\Commands;

use Event;
use Illuminate\Console\Command;
use Matchappen\Events\EmailWasRejected;

class HandleEmailRejection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:handle-email-rejection {email : the email address that was rejected/bounced}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Raise the EmailWasRejected event for an email address';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Event::fire(new EmailWasRejected($this->argument('email')));
    }
}
