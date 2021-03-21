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
        $this->assertCount(1, $structure->composition());
    }

    public function testCalculateOffset()
    {
        (new IdStructure)
            ->add($workerId = Field::make('worker_id', 5))
            ->add($processId = Field::make('process_id', 5))
            ->calculateOffset();

        $this->assertSame(5, $workerId->offset());
        $this->assertSame(0, $processId->offset());
    }
}
