<?php

namespace AlexManno\Remix\Pipelines\Interfaces;

use SplQueue;

interface PipelineInterface extends StageInterface
{
    public function getStages(): SplQueue;

    public function pipe(StageInterface $stage): self;
}
