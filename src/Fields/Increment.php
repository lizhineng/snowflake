<?php

namespace Zhineng\Snowflake\Fields;

class Increment extends Field
{
    protected ?Field $depends = null;

    protected int $last = -1;

    public function for($field): self
    {
        $this->depends = $field;

        return $this;
    }

    protected function hasDepends(): bool
    {
        return (bool) $this->depends;
    }

    protected function depends(): Field
    {
        return $this->depends;
    }

    public function value(): int
    {
        if ($this->hasDepends()) {
            if ($this->depends()->pureValue() !== $this->last) {
                $this->value = 0;
                $this->last = $this->depends->pureValue();
            } else {
                $this->value++;
            }

            return $this->value;
        }

        return $this->value++;
    }
}
