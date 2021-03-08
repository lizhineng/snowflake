<?php

namespace Zhineng\Snowflake\Fields;

class Timestamp extends Field
{
    protected int $epoch = 0;

    public function startingFrom(int $timestamp): self
    {
        $this->epoch = $timestamp;

        return $this;
    }

    public function epoch(): int
    {
        return $this->epoch;
    }

    public function now()
    {
        return intval(microtime(true) * 1000);
    }

    public function retrieve(int $snowflake): int
    {
        return parent::retrieve($snowflake) + $this->epoch();
    }

    public function value(): int
    {
        return $this->now() - $this->epoch();
    }
}
