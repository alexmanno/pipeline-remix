<?php

namespace Examples;

use AlexManno\Remix\Pipelines\Interfaces\PayloadInterface;
use AlexManno\Remix\Pipelines\Interfaces\StageInterface;
use AlexManno\Remix\Pipelines\Pipeline;
use AlexManno\Remix\Pipelines\SimplePayload;

require_once __DIR__ . '/../vendor/autoload.php';

class SayHello implements StageInterface
{
    /**
     * @param PayloadInterface $payload
     *
     * @return PayloadInterface
     */
    public function __invoke(PayloadInterface $payload): PayloadInterface
    {
        $payload->setData('Hello!');

        return $payload;
    }
}

class SayMyNameIsAlessandro implements StageInterface
{
    /**
     * @param PayloadInterface $payload
     *
     * @return PayloadInterface
     */
    public function __invoke(PayloadInterface $payload): PayloadInterface
    {
        $data = $payload->getData();
        $payload->setData($data . ' My name is Alessandro');

        return $payload;
    }
}


$pipeline = new Pipeline();
$payload = new SimplePayload();

$pipeline
    ->pipe(new SayHello)                // Append "Hello!" to TextState
    ->pipe(new SayMyNameIsAlessandro);  // Append "My name is Alessandro" to TextState
$payload = $pipeline($payload);         // Pass an initial State

echo $payload->getData();               // Print: Hello! My name is Alessandro!
