<?php

declare(strict_types=1);

namespace User;

interface UserInterface
{
    public function getUserId(): ?int;
    public function setUserId(int $userId): self;
}
