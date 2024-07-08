<?php

declare(strict_types=1);

namespace SmfTest\App\Actions;

use App\Actions\LoginAction;
use Psr\Http\Message\ResponseInterface;

class LoginActionTest extends AbstractActionTestCase
{
    private string $sa = 'loginTwo';

    public function setUp(): void
    {
        parent::setUp();
        $this->action = $this->actionManager->get(LoginAction::class);
    }

    public function testActionInvocationReturnsResponse()
    {
        $action   = $this->action;
        $response = $action();
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    public function testActionInvocationWithSubActionReturnsResponse()
    {
        $action   = $this->action;
        $response = $action($this->sa);
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }
}
