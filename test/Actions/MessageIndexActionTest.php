<?php

declare(strict_types=1);

namespace SmfTest\App\Actions;

use App\Actions\MessageIndexAction;
use Psr\Http\Message\ResponseInterface;

class MessageIndexActionTest extends AbstractActionTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->action = $this->actionManager->get(MessageIndexAction::class);
    }

    public function testActionInvocationReturnsResponse()
    {
        $action   = $this->action;
        $response = $action();
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }
}
