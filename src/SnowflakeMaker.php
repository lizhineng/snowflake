<?php

namespace Zhineng\Snowflake;

class SnowflakeMaker
{
    protected IdStructure $structure;

    public function usingStructure(IdStructure $structure): self
    {
        $this->structure = $structure->calculateOffset();

        return $this;
    }

    public function parse(Snowflake | string | int $snowflake): Snowflake
    {
        if ($snowflake instanceof Snowflake) {
            $snowflake = $snowflake->id;
        } elseif (is_string($snowflake)) {
            $snowflake = (int) $snowflake;
        }

        $data = ['id' => $snowflake];

        foreach ($this->structure->composition() as $field) {
            $data[$field->name()] = $field->retrieve($snowflake);
        }

        return new Snowflake($data);
    }

    public function nextId(): int
    {
        return $this->next()->id;
    }

    public function next(): Snowflake
    {
        $data = ['id' => 0];

        foreach ($this->structure->composition() as $field) {
            $data[$field->name()] = $value = $field->value();
            $data['id'] = $data['id'] | $value << $field->offset();
        }

        return new Snowflake($data);
    }
}
