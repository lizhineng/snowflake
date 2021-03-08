<?php

namespace Zhineng\Snowflake;

/**
 * @property-read string $id
 */
class Snowflake
{
    public function __construct(
        protected array $data = []
    )
    {
    }

    public function __get(string $name)
    {
        return $this->data[$name] ?? null;
    }
}
