<?php

declare(strict_types=1);

namespace SmfTest\App\Actions;

use App\ActionInterface;
use App\Actions\ActionManager;
use Laminas\ServiceManager\ServiceManager;
use PHPUnit\Framework\TestCase;

abstract class AbstractActionTestCase extends TestCase
{
    private const CONTAINER_FILE = __DIR__ . '/../../config/container.php';

    protected ActionManager $actionManager;
    protected ServiceManager $sm;
    protected ActionInterface $action;

    public function setUp(): void
    {
        $this->sm = require self::CONTAINER_FILE;
        $this->actionManager = $this->sm->get(ActionManager::class);
    }
}
