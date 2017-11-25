<?php

namespace Remix\Pipelines;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Remix\Pipelines\Interfaces\StateInterface;

class RequestResponseState implements StateInterface
{
    /** @var RequestInterface */
    public $request;
    /** @var ResponseInterface */
    public $response;

    /**
     * State constructor.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     */
    public function __construct(RequestInterface $request, ResponseInterface $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     *
     * @return RequestResponseState
     */
    public static function create(RequestInterface $request, ResponseInterface $response)
    {
        return new self($request, $response);
    }

    /**
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    /**
     * @param RequestInterface $request
     *
     * @return RequestResponseState
     */
    public function setRequest(RequestInterface $request): self
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    /**
     * @param ResponseInterface $response
     *
     * @return RequestResponseState
     */
    public function setResponse(ResponseInterface $response): self
    {
        $this->response = $response;

        return $this;
    }
}
