<?php


namespace Sfneal\Tracking\Console;


use Illuminate\Console\Command;
use Sfneal\Tracking\Jobs\CleanDevTrackingJob;

class CleanDevTrackingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tracking:clean-dev';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removing tracking data that was created in a development environment';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        // Dispatch the cleaning job
        (new CleanDevTrackingJob())->handle();
    }
}
