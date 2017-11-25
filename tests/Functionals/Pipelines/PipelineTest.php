<?php

namespace Tests\Functionals\Pipelines;

use Remix\Pipelines\Interfaces\StageInterface;
use Remix\Pipelines\Pipeline;
use Tests\TestCase;

class PipelineTest extends TestCase
{
    public function testPipeOneStage()
    {
        $addTwo = $this->getAddTwoStage();

        $pipeline = new Pipeline();
        $pipeline->pipe($addTwo); // Add 2

        $state = $this->createState()->set(2);
        $this->assertEquals(4, $pipeline->run($state)->get());

        $state = $this->createState()->set(6);
        $this->assertEquals(8, $pipeline->run($state)->get());

        $state = $this->createState()->set(-2);
        $this->assertEquals(0, $pipeline->run($state)->get());
    }

    public function testPipeTwoStage()
    {
        $addTwo = $this->getAddTwoStage();
        $factorial = $this->getFactorialStage();

        $pipeline = new Pipeline();
        $pipeline
            ->pipe($addTwo)// Add 2
            ->pipe($factorial); // Get factorial

        $state = $this->createState()->set(4); // Set state = 4

        $this->assertEquals(720, $pipeline->run($state)->get());
    }

    protected function getAddTwoStage()
    {
        return
            new class() implements StageInterface {
                public function __invoke($state)
                {
                    return $state->set($state->get() + 2); // Add two
                }
            };
    }

    protected function getFactorialStage()
    {
        return
            new class() implements StageInterface {
                public function __invoke($state)
                {
                    $number = $state->get();

                    if ($number < 2) {
                        return $state->set(1);
                    }

                    return $state->set(
                        $number *
                        $this(
                            $state->set($number - 1)
                        )->get()
                    );
                }
            };
    }
}
