<?php

namespace AlexManno\Remix\Pipelines;

use AlexManno\Remix\Pipelines\Interfaces\PayloadInterface;

class SimplePayload implements PayloadInterface
{
    private $data;

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function setData($data): void
    {
        $this->data = $data;
    }
}
