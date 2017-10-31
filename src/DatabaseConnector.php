<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 23/10/2017
 * Time: 13:02
 */

namespace Com\NickelIT\UniqueableJobs;


use Illuminate\Support\Arr;

class DatabaseConnector extends \Illuminate\Queue\Connectors\DatabaseConnector
{
    /**
     * @param array $config
     * @return DatabaseQueue
     */
    public function connect(array $config)
    {
        return new DatabaseQueue(
            $this->connections->connection(Arr::get($config, 'connection')),
            $config['table'],
            $config['queue'],
            Arr::get($config, 'retry_after', 60)
        );
    }
}