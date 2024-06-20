<?php

declare(strict_types=1);

namespace App;

use Laminas\Diactoros\ServerRequest;
use Laminas\EventManager\Event;
use Laminas\View\Model\ViewModel;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AppEvent extends Event
{
    private App $app;
    private ServerRequest $request;
    private ResponseInterface $response;
    private mixed $result;
    private $template;

    public function setApp(App $app): self
    {
        $this->setParam('app', $app);
        $this->app = $app;
        return $this;
    }

    public function getApp(): App
    {
        return $this->app;
    }

    public function setRequest(ServerRequestInterface $request): self
    {
        $this->setParam('request', $request);
        $this->request = $request;
        return $this;
    }

    public function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }

    public function setResponse(ResponseInterface $response): self
    {
        $this->setParam('response', $response);
        $this->response = $response;
        return $this;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    public function setTemplate(ViewModel $template): self
    {
        $this->setParam('template', $template);
        $this->template = $template;
        return $this;
    }

    public function getTemplate(): ViewModel
    {
        return $this->template;
    }

    public function setResult(mixed $result): self
    {
        $this->setParam('result', $result);
        $this->result = $result;
        return $this;
    }

    public function getResult(): mixed
    {
        return $this->result;
    }
}
