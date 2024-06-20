<?php

declare(strict_types=1);

namespace Mod\LoginMod;

use Mod\LoginMod\Entity\LoginThingy;

final class LoginMod
{
    public const TARGET_EVENT = 'login';

    public function __construct(
        private Entity\LoginThingy $loginThingy
    ) {
    }
}
