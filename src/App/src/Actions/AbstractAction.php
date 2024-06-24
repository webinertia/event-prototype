<?php

declare(strict_types=1);

namespace App\Actions;

use App\ActionAwareInterface;
use App\ActionAwareTrait;
use App\ActionInterface;
use Laminas\EventManager\EventManagerAwareInterface;
use Laminas\EventManager\EventManagerAwareTrait;
use Template\TemplateAwareInterface;
use Template\TemplateAwareTrait;

abstract class AbstractAction implements ActionInterface, TemplateAwareInterface, EventManagerAwareInterface
{
    //use ActionAwareTrait;
    use EventManagerAwareTrait;
    use TemplateAwareTrait;
}
