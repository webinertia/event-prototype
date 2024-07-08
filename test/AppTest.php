<?php

declare(strict_types=1);

namespace SmfTest\App;

use App\App;
use App\AppEvent;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Laminas\ServiceManager\ServiceManager;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AppTest extends TestCase
{
    private const CONTAINER_FILE = __DIR__ . '/../config/container.php';

    /** @var App */
    private App $app;

    /** @var ServiceLocatorInterface&MockObject */
    private $sm;

    /** @var AppEvent&MockObject */
    private $event;

    public function setUp(): void
    {
        $this->sm  = require self::CONTAINER_FILE;
        $this->app = $this->sm->get(App::class);
    }

    public function testTestAppCreatedInSetUp(): void
    {
        $this->assertInstanceOf(App::class, $this->app);
    }

    public function testAppReturnsServiceManager(): void
    {
        $sm = $this->app->getServiceManager();
        $this->assertInstanceOf(ServiceManager::class, $sm);
    }

    // public function testAppReturnsResponse(): void
    // {
    //     $event   = $this->app->getEvent();
    //     $request = $this->sm->get(ServerRequestInterface::class);
    //     $request = $request->withQueryParams(['board' => '1.0']);
    //     $event->setRequest($request);
    //     $responseInterface = $this->sm->get(ResponseInterface::class);
    //     $this->app->run();
    //     $response = $event->getResult();
    //     $this->assertInstanceOf($responseInterface::class, $response);
    // }
}
