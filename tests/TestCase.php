<?php

namespace AlexManno\Remix\Tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Prophecy\Prophet;
use AlexManno\Remix\Pipelines\Interfaces\StageInterface;
use AlexManno\Remix\Pipelines\SimplePayload;

class TestCase extends PHPUnitTestCase
{
    /** @var Prophet */
    protected $prophet;

    protected function setup()
    {
        $this->prophet = new Prophet();
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }

    /**
     * @return StageInterface|object
     */
    protected function getStage()
    {
        $phropecy = $this->prophesize();
        $phropecy->willImplement(StageInterface::class);

        return $phropecy->reveal();
    }

    /**
     * @return SimplePayload
     */
    protected function createPayload(): SimplePayload
    {
        return new SimplePayload();
    }
}
