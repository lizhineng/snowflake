<?php

namespace Zhineng\Snowflake\Tests;

use PHPUnit\Framework\TestCase;
use Zhineng\Snowflake\Fields\Field;
use Zhineng\Snowflake\Fields\Increment;
use Zhineng\Snowflake\Fields\Timestamp;
use Zhineng\Snowflake\IdStructure;
use Zhineng\Snowflake\Snowflake;
use Zhineng\Snowflake\SnowflakeMaker;

class SnowflakeMakerTest extends TestCase
{
    protected SnowflakeMaker $maker;

    protected IdStructure $structure;

    protected function setUp(): void
    {
        parent::setUp();

        $year2015InMilliseconds = strtotime('2015-01-01 00:00:00') * 1000;

        $this->structure = (new IdStructure)
            ->add($timestamp = Timestamp::make('timestamp', 42)->startingFrom($year2015InMilliseconds))
            ->add(Field::make('worker_id', 5, 1))
            ->add(Field::make('process_id', 5, 2))
            ->add(Increment::make('increment', 12)->for($timestamp));

        $this->maker = (new SnowflakeMaker)->usingStructure($this->structure);
    }

    public function testGenerateId()
    {
        //
    }
}
