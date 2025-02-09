<?php

namespace App\Shared\Domain\ValueObject;

use Symfony\Component\Uid\Uuid as SymfonyUuid;

abstract class Uuid implements \Stringable
{
    public function __construct(protected string $value)
    {
        $this->ensureIsValidUuid($value);
    }

    public function __toString(): string
    {
        return $this->value();
    }

    public function value(): string
    {
        return $this->value;
    }

    public static function random(): self
    {
        return new static(SymfonyUuid::v4()->toString());
    }

    public function equals(self $other): bool
    {
        return $this->value() === $other->value();
    }

    private function ensureIsValidUuid(string $value): void
    {
        if (!SymfonyUuid::isValid($value)) {
            throw new \InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', self::class, $value));
        }
    }
}
