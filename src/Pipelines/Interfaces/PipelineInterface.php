<?php

namespace AlexManno\Remix\Pipelines\Interfaces;

use SplQueue;

interface PipelineInterface
{
    public function getStages(): SplQueue;

    public function pipe(StageInterface $stage): self;

    public function run(StateInterface $state): StateInterface;
}
