<?php

namespace Examples;

use Remix\Pipelines\Interfaces\StageInterface;
use Remix\Pipelines\Pipeline;
use Remix\Pipelines\SimpleState;

require_once __DIR__ . '/../vendor/autoload.php';

$state = new class extends SimpleState
{
    public $data = '';

    public function append(string $paragraph)
    {
        $this->data .= $paragraph . " ";

        return $this;
    }
};

$sayHello = new class implements StageInterface
{
    public function __invoke($state)
    {
        return $state->append('Hello!');
    }
};

$sayMyNameIsAlessandro = new class implements StageInterface
{
    public function __invoke($state)
    {
        return $state->append('My name is Alessandro!');
    }
};

$pipeline = new Pipeline();

$state = $pipeline
    ->pipe($sayHello)               // Append "Hello!" to TextState
    ->pipe($sayMyNameIsAlessandro)  // Append "My name is Alessandro" to TextState
    ->run($state);                  // Pass an initial State

echo $state->get(); // Print: Hello! My name is Alessandro!