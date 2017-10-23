<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 23/10/2017
 * Time: 12:13
 */

namespace Com\NickelIT\UniqueableJobs;


trait Dispatchable
{
    /**
     * Dispatch the job with the given arguments.
     *
     * @return PendingDispatch
     */
    public static function dispatch()
    {
        return new PendingDispatch(new static(...func_get_args()));
    }
}