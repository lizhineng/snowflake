<?php

namespace Zhineng\Snowflake;

use Zhineng\Snowflake\Fields\Field;

class IdStructure
{
    protected array $composition = [];

    public function add(Field $field): self
    {
        $this->composition[] = $field;

        return $this;
    }

    public function composition(): array
    {
        return $this->composition;
    }

    public function calculateOffset(): self
    {
        $offset = 0;

        foreach (array_reverse($this->composition()) as $field) {
            $field->setOffset($offset);
            $offset += $field->bits();
        }

        return $this;
    }
}
