<?php

namespace AlexManno\Remix\Pipelines\Interfaces;

interface StageInterface
{
    public function __invoke($state);
}
