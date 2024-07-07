<?php

declare(strict_types=1);

namespace App;

interface AppInterface
{
    final public const ERROR_aCTION_CANNOT_DISPATCH = 'error-action-cannot-dispatch';
    final public const ERROR_ACTION_NOT_FOUND       = 'error-action-not-found';
    final public const ERROR_ACTION_INVALID         = 'error-action-invalid';
    final public const ERROR_EXCEPTION              = 'error-exception';
    final public const ERROR_ROUTER_NO_MATCH        = 'error-router-no-match';
}
