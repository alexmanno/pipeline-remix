<?php

namespace AlexManno\Remix\Tests\Pipelines\Unit;

use AlexManno\Remix\Pipelines\Interfaces\StageInterface;
use AlexManno\Remix\Pipelines\Interfaces\StateInterface;
use AlexManno\Remix\Pipelines\Pipeline;
use AlexManno\Remix\Tests\TestCase;

class PipelineTest extends TestCase
{
    public function testPipe()
    {
        $stage = $this->getStage();

        $pipeline = new Pipeline();
        $pipeline->pipe($stage);

        $this->assertEquals(1, $pipeline->count());
        $pipeline->pipe($stage);
        $this->assertEquals(2, $pipeline->count());
        $pipeline->pipe($stage);
        $this->assertEquals(3, $pipeline->count());
    }

    public function testAdd()
    {
        $pipeline = new Pipeline();
        $pipeline->pipe($this->getStage());

        $this->assertEquals(1, $pipeline->count());

        $subPipeline = new Pipeline();
        $subPipeline->pipe($this->getStage());

        $this->assertEquals(1, $subPipeline->count());

        $pipeline->add($subPipeline);

        $this->assertEquals(2, $pipeline->count());
    }

    public function testRun()
    {
        $phropecy = $this->prophesize();
        $phropecy->willImplement(StateInterface::class);

        $state = $phropecy->reveal();

        $phropecy = $this->prophesize();
        $phropecy->willImplement(StageInterface::class);
        $phropecy->__invoke($state)->willReturn($state);

        $stage = $phropecy->reveal();

        $pipeline = new Pipeline();
        $pipeline->pipe($stage);
        $pipeline->pipe($stage);
        $returnState = $pipeline->run($state);

        $this->assertSame($state, $returnState);
    }
}
