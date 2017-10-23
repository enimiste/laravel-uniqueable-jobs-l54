<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 23/10/2017
 * Time: 12:53
 */

namespace Com\NickelIT\UniqueableJobs;


class DatabaseQueue extends \Illuminate\Queue\DatabaseQueue
{
    /**
     * Push a raw payload to the database with a given delay.
     *
     * @param  string|null $queue
     * @param  string $payload
     * @param  \DateTime|int $delay
     * @param  int $attempts
     * @param string $job
     * @return mixed
     */
    protected function pushToDatabase($queue, $payload, $delay = 0, $attempts = 0, $job = null)
    {
        return $this->database->table($this->table)->insertGetId($this->buildDatabaseRecord(
            $this->getQueue($queue), $payload, $this->availableAt($delay), $attempts, $job
        ));
    }

    /**
     * Push a new job onto the queue.
     *
     * @param  string $job
     * @param  mixed $data
     * @param  string $queue
     * @return mixed
     */
    public function push($job, $data = '', $queue = null)
    {
        return $this->pushToDatabase($queue, $this->createPayload($job, $data), 0, 0, $job);
    }

    /**
     * @param null|string $queue
     * @param string $payload
     * @param int $availableAt
     * @param int $attempts
     * @param string $job
     * @return array
     */
    protected function buildDatabaseRecord($queue, $payload, $availableAt, $attempts = 0, $job = null)
    {
        $data = parent::buildDatabaseRecord($queue, $payload, $availableAt, $attempts);
        if ($this->isUniqueable($job)) {
            $data['job_clazz'] = get_class($job);
            $data['model_clazz'] = $job->unique_clazz;
            $data['model_id'] = $job->unique_id;
        }
        return $data;
    }

    /**
     * @return boolean
     */
    protected function isUniqueable($job)
    {
        if ($job == null) {
            return false;
        }
        $job_clazz = get_class($job);
        $clazz = new \ReflectionClass($job_clazz);
        return in_array(Uniqueable::class, $clazz->getTraitNames());
    }
}