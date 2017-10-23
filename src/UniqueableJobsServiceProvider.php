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

        $migrationsPath = __DIR__ . '/../database/migrations/2017_10_23_114820_add_uniqueable_columns_jobs.php';
        $date = date('Y_m_d_His');
        $publishPath = base_path("/database/migrations/{$date}_add_uniqueable_columns_jobs.php");
        $this->publishes([$migrationsPath => $publishPath], 'migrations');
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
