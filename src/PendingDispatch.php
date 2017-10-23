<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 23/10/2017
 * Time: 12:13
 */

namespace Com\NickelIT\UniqueableJobs;


use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Queue\Connectors\DatabaseConnector;
use Illuminate\Queue\DatabaseQueue;
use Illuminate\Queue\QueueManager;

class PendingDispatch
{
    /**
     * Create a new pending job dispatch.
     *
     * @param  mixed $job
     */
    public function __construct($job)
    {
        $this->job = $job;
    }

    /**
     * Set the desired connection for the job.
     *
     * @param  string|null $connection
     * @return $this
     */
    public function onConnection($connection)
    {
        $this->job->onConnection($connection);

        return $this;
    }

    /**
     * Set the desired queue for the job.
     *
     * @param  string|null $queue
     * @return $this
     */
    public function onQueue($queue)
    {
        $this->job->onQueue($queue);

        return $this;
    }

    /**
     * Set the desired delay for the job.
     *
     * @param  \DateTime|int|null $delay
     * @return $this
     */
    public function delay($delay)
    {
        $this->job->delay($delay);

        return $this;
    }

    /**
     * @param string $clazz
     * @param mixed $id
     */
    public function unique($clazz, $id)
    {
        $this->job->unique($clazz, $id);
    }

    /**
     * @return boolean
     */
    public function isUniqueable()
    {
        $job_clazz = get_class($this->job);
        $clazz = new \ReflectionClass($job_clazz);
        return in_array(Uniqueable::class, $clazz->getTraitNames()) || $clazz->hasMethod('unique');
    }

    /**
     * Handle the object's destruction.
     *
     * @return void
     */
    public function __destruct()
    {
        /** @var QueueManager $v */
        $v = app('queue');
        if ($v->connection() instanceof DatabaseQueue && $this->isUniqueable()) {
            if ($this->job->unique_apply) {
                if (\DB::table('jobs')->where('model_clazz', '=', $this->job->unique_clazz)
                        ->where('model_id', '=', $this->job->unique_id)
                        ->where('job_clazz', '=', get_class($this->job))
                        ->count() > 0) {
                    return;
                }
            }
        }
        dispatch($this->job);
    }
}