<?php

namespace AlexManno\Remix\Tests\Pipelines\Unit;

use AlexManno\Remix\Pipelines\Interfaces\PayloadInterface;
use AlexManno\Remix\Pipelines\Interfaces\StageInterface;
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
        $phropecy->willImplement(PayloadInterface::class);

        $payload = $phropecy->reveal();

        $phropecy = $this->prophesize();
        $phropecy->willImplement(StageInterface::class);
        $phropecy->__invoke($payload)->willReturn($payload);

        $stage = $phropecy->reveal();

        $pipeline = new Pipeline();
        $pipeline->pipe($stage);
        $pipeline->pipe($stage);
        $returnpayload = $pipeline($payload);

        $this->assertSame($payload, $returnpayload);
    }
}
