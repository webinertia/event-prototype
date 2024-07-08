<?php

declare(strict_types=1);

namespace SmfTest\App\Actions;

use App\Actions\DisplayAction;
use Psr\Http\Message\ResponseInterface;

class DisplayActionTest extends AbstractActionTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->action = $this->actionManager->get(DisplayAction::class);
    }

    public function testActionInvocationReturnsResponse()
    {
        $action   = $this->action;
        $response = $action();
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }
}
