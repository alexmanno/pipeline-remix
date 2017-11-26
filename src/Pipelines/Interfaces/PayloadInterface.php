<?php

namespace AlexManno\Remix\Pipelines\Interfaces;

interface PayloadInterface
{
    /**
     * @return mixed
     */
    public function getData();

    /**
     * @param $data
     *
     * @return void
     */
    public function setData($data): self;
}
