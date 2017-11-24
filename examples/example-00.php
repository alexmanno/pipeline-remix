<?php

namespace Examples;

use Remix\Pipelines\Interfaces\StageInterface;
use Remix\Pipelines\Interfaces\StateInterface;
use Remix\Pipelines\Pipeline;

require_once __DIR__ . '/../vendor/autoload.php';

$state = new class implements StateInterface {
    private $text = '';

    public function append(string $paragraph)
    {
        $this->text .= $paragraph . " ";
    }

    public function getText()
    {
        return $this->text . "\n";
    }
};

$stage1 = new class implements StageInterface {
    /**
     * @param State $state
     */
    public function __invoke($state)
    {
        $state->append('Hello!');
    }
};

$stage2 = new class implements StageInterface {
    /**
     * @param State $state
     */
    public function __invoke($state)
    {
        $state->append('My name is Alessandro!');
    }
};

$pipeline = new Pipeline();

$state = $pipeline
    ->pipe($stage1)
    ->pipe($stage2)
    ->run($state);

echo $state->getText(); // Print: Hello! My name is Alessandro!