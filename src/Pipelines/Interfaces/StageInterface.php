<?php

namespace Remix\Pipelines\Interfaces;

interface StageInterface
{
    public function __invoke($state);
}