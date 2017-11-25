<?php

namespace Remix\Pipelines;

use Remix\Pipelines\Interfaces\StateInterface;

class SimpleState implements StateInterface
{
    public $data;

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     *
     * @return SimpleState
     */
    public function set($data)
    {
        $this->data = $data;

        return $this;
    }
}