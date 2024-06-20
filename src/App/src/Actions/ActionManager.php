<?php

declare(strict_types=1);

namespace App\Actions;

use App\ActionInterface;
use Laminas\ServiceManager\AbstractPluginManager;

final class ActionManager extends AbstractPluginManager
{
    protected $instanceOf = ActionInterface::class;
}
