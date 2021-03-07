<?php

namespace Zhineng\Snowflake\Tests;

use PHPUnit\Framework\TestCase;
use Zhineng\Snowflake\Fields\Field;
use Zhineng\Snowflake\IdStructure;

class IdStructureTest extends TestCase
{
    public function testAddField()
    {
        $structure = new IdStructure;
        $structure->add(Field::make('machine_id', 5));
    }
}