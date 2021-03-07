<?php

namespace Zhineng\Snowflake;

class SnowflakeMaker
{
    protected IdStructure $structure;

    public function usingStructure(IdStructure $structure): self
    {
        $this->structure = $structure;

        return $this;
    }

    public function nextId()
    {
        //
    }
}
