<?php

namespace AlexManno\Remix\Pipelines;

use AlexManno\Remix\Pipelines\Interfaces\PipelineInterface;
use AlexManno\Remix\Pipelines\Interfaces\StageInterface;
use AlexManno\Remix\Pipelines\Interfaces\StateInterface;
use SplQueue;

class Pipeline implements PipelineInterface
{
    /** @var SplQueue */
    private $stages;

    /**
     * Pipeline constructor.
     */
    public function __construct()
    {
        $this->stages = new SplQueue();
    }

    public function pipe(StageInterface $stage): PipelineInterface
    {
        $this->stages->enqueue($stage);

        return $this;
    }

    public function getStages(): \SplQueue
    {
        return $this->stages;
    }

    public function add(PipelineInterface $pipeline): PipelineInterface
    {
        $queue = $pipeline->getStages();

        $queue->rewind();
        while ($queue->valid()) {
            $this->stages->enqueue($queue->current());
            $queue->next();
        }

        return $this;
    }

    public function count(): int
    {
        return $this->stages->count();
    }

    public function run(StateInterface $state): StateInterface
    {
        $this->stages->rewind();
        while ($this->stages->valid()) {
            $state = $this->stages->current()($state);
            $this->stages->next();
        }

        return $state;
    }
}
