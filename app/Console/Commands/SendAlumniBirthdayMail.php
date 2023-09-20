<?php

namespace App\Console\Commands;

use App\Jobs\SendAlumniBirthday;
use Illuminate\Console\Command;

class SendAlumniBirthdayMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alumni:birthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends birthday email to alumni.';

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
        dispatch(new SendAlumniBirthday());
    }
}
