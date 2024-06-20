<?php

declare(strict_types=1);

namespace App;

enum AppEvents: string
{
    case Bootstrap     = 'app.bootstrap';
    case Dispatch      = 'app.dispatch';
    case DispatchError = 'app.dispatch.error';
    case Finish        = 'app.finish';
    case Render        = 'app.render';
    case RenderError   = 'app.render.error';
}
