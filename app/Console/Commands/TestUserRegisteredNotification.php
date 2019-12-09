<?php

namespace App\Console\Commands;

use App\Notifications\NewCampaignAddedNotification;
use Illuminate\Console\Command;
use App\User;
use App\Notifications\NewUserRegistered;


class TestUserRegisteredNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:slack';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test slack notification for new user registered.';

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
        (new NewCampaignAddedNotification)->toslack(User::first()->name);
    }
}
