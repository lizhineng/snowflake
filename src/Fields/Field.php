<?php

namespace Zhineng\Snowflake\Fields;

use InvalidArgumentException;
use RuntimeException;

class Field
{
    protected int $max = -1;

    protected int $offset = -1;

    public function __construct(
        protected string $name,
        protected int $bits,
        protected int $value = 0
    ) {
        $this->initialize();
    }

    public static function make(string $name, int $bits, int $value = 0): static
    {
        return new static($name, $bits, $value);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function bits(): int
    {
        return $this->bits;
    }

    public function max(): int
    {
        return $this->max;
    }

    public function offset(): int
    {
        if ($this->offset === -1) {
            throw new RuntimeException("The {$this->name()} field is missing offset value.");
        }

        return $this->offset;
    }

    public function setOffset(int $offset): self
    {
        $this->offset = $offset;

        return $this;
    }

    public function retrieve(int $snowflake): int
    {
        return ($snowflake & $this->max() << $this->offset()) >> $this->offset();
    }

    public function value(): int
    {
        return $this->pureValue();
    }

    protected function pureValue(): int
    {
        return $this->value;
    }

    protected function initialize(): void
    {
        $this->calculateMaxValue();
        $this->validate($this->value);
    }

    protected function calculateMaxValue(): void
    {
        $this->max = 2 ** $this->bits() - 1;
    }

    protected function validate(int $value): void
    {
        if ($this->max() >= $value) {
            return;
        }

        throw new InvalidArgumentException("The maximum value of {$this->name()} field is {$this->max()}, {$value} given.");
    }
}
