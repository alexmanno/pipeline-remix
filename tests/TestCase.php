<?php

namespace Tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Prophecy\Prophet;
use Remix\Pipelines\Interfaces\StageInterface;

class TestCase extends PHPUnitTestCase
{
    /** @var Prophet */
    protected $prophet;

    protected function setup()
    {
        $this->prophet = new \Prophecy\Prophet();
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
}
