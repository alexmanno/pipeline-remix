<?php

namespace AlexManno\Remix\Pipelines\Interfaces;

interface StageInterface
{
    public function __invoke(PayloadInterface $payload): PayloadInterface;
}
