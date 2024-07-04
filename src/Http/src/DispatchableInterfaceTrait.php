<?php

declare(strict_types=1);

namespace Http;

use App\ActionAwareTrait;
use Laminas\Diactoros\ServerRequest;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\EventInterface;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Template\TemplateAwareTrait;

/**
 * @deprecated
 */
trait DispatchableInterfaceTrait
{
    use ActionAwareTrait;
    use TemplateAwareTrait;

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(AppEvent::EVENT_DISPATCH, [$this, 'onDispatch'], $priority);
    }

    public function onDispatch(AppEvent $event): ?ResponseInterface
    {
        /** @var ServerRequest */
        $request = $event->getParam('request');
        $params  = $request->getQueryParams();

        if (! empty($params['action'])) {
            try {
                /**
                 * $action is the action=someaction
                 *
                 * The called action must return a ResponseInterface instance or it will 404
                 *
                 * Maps ['config']['actions'][$action]['class'] to $actionManager service name
                 * todo: Improve this so that in development mode is just displays the exception, and in production it shows the 404 page
                 *
                 */
                $action = $this->getActionClass($params['action']);
                if ($this->actionManager->has((string) $action)) {
                    $action = $this->actionManager->get($action);
                } elseif (
                    ! $this->actionManager->has((string) $action) // action not found
                    && isset($this->config['debug']) // $this->config['debug'] is set
                    && $this->config['debug'] // $this->config['debug'] is true, were in development mode
                ) {
                    // not found and in development mode, then this will throw an exception
                    $action = $this->actionManager->get((string) $action);
                } elseif (
                    ! $this->actionManager->has((string) $action) // action not found
                    && isset($this->config['debug']) // $this->config['debug'] is set
                    && ! $this->config['debug'] // $this->config['debug'] is true, were in development mode
                ) {
                    // not found and in production mode
                    $event->setError('404 Not Found.');
                }
                // when in production mode, if the action is not found just throw a 404
                return $action?->run();
            } catch (ServiceNotFoundException $e) {
                throw $e;
            }
        }
        return null;
    }
}
