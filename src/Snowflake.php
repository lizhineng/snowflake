<?php

namespace Zhineng\Snowflake;

use Stringable;

/**
 * @property-read string $id
 */
class Snowflake implements Stringable
{
    public function __construct(
        protected array $data = []
    ) {}

    public function __get(string $name)
    {
        return $this->data[$name] ?? null;
    }

    public function __toString()
    {
        return $this->id;
    }
}
