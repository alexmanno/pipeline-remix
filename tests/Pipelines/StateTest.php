<?php

namespace Tests\Pipelines;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Remix\Pipelines\State;
use Tests\TestCase;

class StateTest extends TestCase
{
    public function testConstruct()
    {
        $request = $this->prophesize()->willImplement(RequestInterface::class)->reveal();
        $response = $this->prophesize()->willImplement(ResponseInterface::class)->reveal();

        $state = new State($request, $response);

        $this->assertSame($request, $state->getRequest());
        $this->assertSame($response, $state->getResponse());
    }

    public function testCreate()
    {
        $request = $this->prophesize()->willImplement(RequestInterface::class)->reveal();
        $response = $this->prophesize()->willImplement(ResponseInterface::class)->reveal();

        $state = State::create($request, $response);

        $this->assertSame($request, $state->getRequest());
        $this->assertSame($response, $state->getResponse());
    }

    public function testSetters()
    {
        $request = $this->prophesize()->willImplement(RequestInterface::class)->reveal();
        $request2 = $this->prophesize()->willImplement(RequestInterface::class)->reveal();
        $response = $this->prophesize()->willImplement(ResponseInterface::class)->reveal();
        $response2 = $this->prophesize()->willImplement(ResponseInterface::class)->reveal();

        $state = new State($request, $response);

        $state->setRequest($request2);
        $state->setResponse($response2);

        $this->assertNotSame($request, $state->getRequest());
        $this->assertNotSame($response, $state->getResponse());
        $this->assertSame($request2, $state->getRequest());
        $this->assertSame($response2, $state->getResponse());
    }
}
