<?php

namespace Tests\Pipelines\Unit;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Remix\Pipelines\RequestResponseState;
use Tests\TestCase;

class StateTest extends TestCase
{
    public function testConstruct()
    {
        $request = $this->prophesize()->willImplement(RequestInterface::class)->reveal();
        $response = $this->prophesize()->willImplement(ResponseInterface::class)->reveal();

        $state = new RequestResponseState($request, $response);

        $this->assertSame($request, $state->getRequest());
        $this->assertSame($response, $state->getResponse());
    }

    public function testCreate()
    {
        $request = $this->prophesize()->willImplement(RequestInterface::class)->reveal();
        $response = $this->prophesize()->willImplement(ResponseInterface::class)->reveal();

        $state = RequestResponseState::create($request, $response);

        $this->assertSame($request, $state->getRequest());
        $this->assertSame($response, $state->getResponse());
    }

    public function testSetters()
    {
        $request = $this->prophesize()->willImplement(RequestInterface::class)->reveal();
        $request2 = $this->prophesize()->willImplement(RequestInterface::class)->reveal();
        $response = $this->prophesize()->willImplement(ResponseInterface::class)->reveal();
        $response2 = $this->prophesize()->willImplement(ResponseInterface::class)->reveal();

        $state = new RequestResponseState($request, $response);

        $state->setRequest($request2);
        $state->setResponse($response2);

        $this->assertNotSame($request, $state->getRequest());
        $this->assertNotSame($response, $state->getResponse());
        $this->assertSame($request2, $state->getRequest());
        $this->assertSame($response2, $state->getResponse());
    }
}
