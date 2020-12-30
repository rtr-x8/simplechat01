<?php


namespace Shared\Domain;


use Illuminate\Support\Str;

class Identifier
{
    private string $value;

    /**
     * Identifier constructor.
     * @param  string  $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function new()
    {
        return Identifier::of(Str::orderedUuid());
    }

    public static function of($value)
    {
        return static($value);
    }

    public function equals(Identifier $identifier): bool
    {
        if (get_class($this) !== get_class($identifier)) {
            return false;
        }

        return $this->value() === $identifier->value();
    }

    public function value(): string
    {
        return $this->value;
    }
}
