<?php


namespace Shared\Domain;


class Text
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

    public static function of($value)
    {
        return new static($value);
    }

    public function equals(Text $shortText): bool
    {
        if (get_class($this) !== get_class($shortText)) {
            return false;
        }

        return $this->value() === $shortText->value();
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->value();
    }
}
