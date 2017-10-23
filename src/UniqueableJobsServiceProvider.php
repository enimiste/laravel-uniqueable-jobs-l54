<?php

namespace Com\NickelIT\UniqueableJobs;

use Com\NickelIT\UniqueableJobs\DatabaseConnector;
use Illuminate\Queue\QueueManager;
use Illuminate\Support\ServiceProvider;

class UniqueableJobsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /** @var QueueManager $manager */
        $manager = app('queue');
        $manager->addConnector('database', function () {
            return new DatabaseConnector($this->app['db']);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
