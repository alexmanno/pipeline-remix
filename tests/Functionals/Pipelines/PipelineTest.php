<?php

namespace AlexManno\Remix\Tests\Functionals\Pipelines;

use AlexManno\Remix\Pipelines\Interfaces\PayloadInterface;
use AlexManno\Remix\Pipelines\Interfaces\StageInterface;
use AlexManno\Remix\Pipelines\Pipeline;
use AlexManno\Remix\Tests\TestCase;

class PipelineTest extends TestCase
{
    public function testPipeOneStage()
    {
        $addTwo = $this->getAddTwoStage();

        $pipeline = new Pipeline();
        $pipeline->pipe($addTwo); // Add 2

        $payload = $this->createPayload();
        $payload->setData(2);
        $this->assertEquals(4, $pipeline($payload)->getData());

        $payload = $this->createPayload();
        $payload->setData(6);
        $this->assertEquals(8, $pipeline($payload)->getData());

        $payload = $this->createPayload();
        $payload->setData(-2);
        $this->assertEquals(0, $pipeline($payload)->getData());
    }

    public function testPipeTwoStage()
    {
        $addTwo = $this->getAddTwoStage();
        $factorial = $this->getFactorialStage();

        $pipeline = new Pipeline();
        $pipeline
            ->pipe($addTwo)// Add 2
            ->pipe($factorial); // Get factorial

        $payload = $this->createPayload();
        $payload->setData(4); // Set payload = 4

        $this->assertEquals(720, $pipeline($payload)->getData());
    }

    protected function getAddTwoStage()
    {
        return
            new class() implements StageInterface
            {
                public function __invoke(PayloadInterface $payload): PayloadInterface
                {
                    $payload->setData($payload->getData() + 2); // Add two

                    return $payload;
                }
            };
    }

    protected function getFactorialStage()
    {
        return
            new class() implements StageInterface
            {
                public function __invoke(PayloadInterface $payload): PayloadInterface
                {
                    $number = $payload->getData();

                    if ($number < 2) {
                        $payload->setData(1);

                        return $payload;
                    }

                    $payload->setData($number - 1);
                    $payload->setData(
                        $number * $this($payload)->getData()
                    );

                    return $payload;
                }
            };
    }
}
