<?php

namespace Examples;

use Remix\Pipelines\Interfaces\StageInterface;
use Remix\Pipelines\Pipeline;
use Remix\Pipelines\SimpleState;

require_once __DIR__ . '/../vendor/autoload.php';

class TextState extends SimpleState
{

    public $data = '';

    public function append(string $paragraph)
    {
        $this->data .= $paragraph . " ";

        return $this;
    }
}

class SayHello implements StageInterface
{
    /**
     * @param TextState $state
     */
    public function __invoke($state)
    {
        return $state->append('Hello!');
    }
}

class SayMyNameIsAlessandro implements StageInterface
{
    /**
     * @param TextState $state
     */
    public function __invoke($state)
    {
        return $state->append('My name is Alessandro!');
    }
}


$pipeline = new Pipeline();

/** @var TextState $state */
$state = $pipeline
    ->pipe(new SayHello)               // Append "Hello!" to TextState
    ->pipe(new SayMyNameIsAlessandro)  // Append "My name is Alessandro" to TextState
    ->run(new TextState);              // Pass an initial State

echo $state->get(); // Print: Hello! My name is Alessandro!