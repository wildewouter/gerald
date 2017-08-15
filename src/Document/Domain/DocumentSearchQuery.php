<?php

namespace Document\Domain;

final class DocumentSearchQuery
{
    /**
     * @var string
     */
    private $key;
    /**
     * @var string
     */
    private $value;

    public function __construct(string $key, string $value)
    {
        $this->key   = $key;
        $this->value = $value;
    }

    public function key(): string
    {
        return $this->key;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function toArray(): array
    {
        return [$this->key => $this->value];
    }
}
