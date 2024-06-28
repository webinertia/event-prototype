<?php

declare(strict_types=1);

namespace App;

use Laminas\Diactoros\ServerRequest;
use Laminas\EventManager\Event;
use Laminas\View\Model\ViewModel;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Template\TemplateModel;
use Throwable;

final class AppEvent extends Event
{
    final public const EVENT_BOOTSTRAP      = 'bootstrap';
    final public const EVENT_DISPATCH       = 'dispatch';
    final public const EVENT_DISPATCH_ERROR = 'dispatch.error';
    final public const EVENT_FINISH         = 'finish';
    final public const EVENT_RENDER         = 'render';
    final public const EVENT_RENDER_ERROR   = 'render.error';

    private App $app;
    private ServerRequest $request;
    private ResponseInterface $response;
    private mixed $result;
    private $template;
    private TemplateModel $templateModel;

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

    public function setTemplate(TemplateModel $template): self
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

    public function isError(): bool
    {
        return (bool) $this->getParam('error', false);
    }

    public function setError(string $message): self
    {
        $this->setParam('error', $message);
        return $this;
    }

    public function getError(): ?string
    {
        return $this->getParam('error');
    }

    public function isException(): bool
    {
        return (bool) $this->getParam('exception', false);
    }

    public function setException(Throwable $th): self
    {
        $this->setParam('exception', $th);
        return $this;
    }

    public function getException(): ?Throwable
    {
        return $this->getParam('exception');
    }
}
