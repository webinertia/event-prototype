<?php

declare(strict_types=1);

namespace Http;

trait Psr7AwareTrait
{
    use RequestAwareTrait;
    use ResponseAwareTrait;
}
