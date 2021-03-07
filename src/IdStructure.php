<?php

namespace Zhineng\Snowflake;

use Zhineng\Snowflake\Fields\Field;

class IdStructure
{
    protected array $format = [];

    public function add(Field $field): self
    {
        $this->format[] = $field;

        return $this;
    }

    public function format(): array
    {
        return $this->format;
    }
}
