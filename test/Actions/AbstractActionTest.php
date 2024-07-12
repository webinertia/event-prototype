<?php

declare(strict_types=1);

namespace SmfTest\App\Actions;

use App\ActionInterface;
use App\Actions\AbstractAction;
use Laminas\EventManager\EventManagerAwareInterface;
use Laminas\EventManager\EventManagerInterface;
use Template\TemplateRendererAwareInterface;
use Template\TemplateRendererInterface;

class AbstractActionTest extends AbstractActionTestCase
{
    private $abstractAction;

    public function setUp(): void
    {
        /** @var ActionInterface&EventManagerAwareInterface&TemplateRendererAwareInterface */
        $this->abstractAction = $this->createMock(AbstractAction::class);
    }

    public function testActionsImplementActionInterface()
    {
        $this->assertInstanceOf(ActionInterface::class, $this->abstractAction);
    }

    public function testActionsAreEventManagerAware()
    {
        $this->assertInstanceOf(EventManagerAwareInterface::class, $this->abstractAction);
    }

    public function testActionsAreTemplateRendererAware()
    {
        $this->assertInstanceOf(TemplateRendererAwareInterface::class, $this->abstractAction);
    }

    public function testActionsCanGetEventManagerInstance()
    {
        $mockManager = $this->createMock(EventManagerInterface::class);

        $this->abstractAction->expects($this->any())
        ->method('getEventManager')
        ->willReturn($mockManager);

        $this->assertInstanceOf(EventManagerInterface::class, $this->abstractAction->getEventManager());
    }

    public function testActionsCanGetTemplateRendererInstance()
    {
        $mockRenderer = $this->createMock(TemplateRendererInterface::class);
        $this->abstractAction->expects($this->any())
        ->method('getRenderer')
        ->willReturn($mockRenderer);
        $this->assertInstanceOf(TemplateRendererInterface::class, $this->abstractAction->getRenderer());
    }
}
