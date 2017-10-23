<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 23/10/2017
 * Time: 11:52
 */

namespace Com\NickelIT\UniqueableJobs;


trait Uniqueable
{
    /** @var bool */
    public $unique_apply = false;
    /** @var  string */
    public $unique_clazz;
    /** @var  mixed */
    public $unique_id;

    /**
     * @param string $clazz
     * @param mixed $id
     */
    public function unique($clazz, $id)
    {
        $this->unique_apply = true;
        $this->unique_clazz = $clazz;
        $this->unique_id = $id;
    }
}