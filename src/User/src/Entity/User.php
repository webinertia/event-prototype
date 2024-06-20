<?php

declare(strict_types=1);

namespace User\Entity;

use Laminas\Stdlib\ArrayObject;
use User\UserInterface;

final class User extends ArrayObject implements UserInterface
{
    public function __construct(
        protected array $input = []
    ) {
        parent::__construct($input, self::ARRAY_AS_PROPS);
    }

    public function getUserId(): ?int
    {
        return $this->offsetGet('userId');
    }

    public function setUserId(int $userId): self
    {
        $this->offsetSet('userId', $userId);
        return $this;
    }
}
