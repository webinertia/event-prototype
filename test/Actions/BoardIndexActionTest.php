<?php

declare(strict_types=1);

namespace SmfTest\App\Actions;

use App\Actions\BoardIndexAction;
use App\AppEvent;
use Psr\Http\Message\ResponseInterface;

class BoardIndexActionTest extends AbstractActionTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->action = $this->actionManager->get(BoardIndexAction::class);
    }

    public function testActionInvocationReturnsResponse()
    {
        $action = $this->action;
        $response = $action();
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    // public function testActionIsDispatchable()
    // {
    //     $response = $this->action->onDispatch(new AppEvent())
    // }
}
