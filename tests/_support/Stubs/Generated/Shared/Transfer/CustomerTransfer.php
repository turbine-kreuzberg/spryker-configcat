<?php

declare(strict_types=1);

namespace Generated\Shared\Transfer;

class CustomerTransfer
{
    public ?string $email;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }
}
