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

        $this->epoch = strtotime('2015-01-01 00:00:00') * 1000;

        $this->structure = (new IdStructure)
            ->add($timestamp = Timestamp::make('timestamp', 42)->startingFrom($this->epoch))
            ->add(Field::make('worker_id', 5, 1))
            ->add(Field::make('process_id', 5, 2))
            ->add(Increment::make('increment', 12)->for($timestamp));

        $this->maker = (new SnowflakeMaker)->usingStructure($this->structure);
    }

    public function testGenerateId()
    {
        $this->assertInstanceOf(Snowflake::class, $snowflake = $this->maker->nextSnowflake());
        $parsed = $this->maker->parse($snowflake);
        $this->assertSame($snowflake->id, $parsed->id);
        $this->assertSame($snowflake->timestamp + $this->epoch, $parsed->timestamp);
        $this->assertSame($snowflake->worker_id, $parsed->worker_id);
        $this->assertSame($snowflake->process_id, $parsed->process_id);
        $this->assertSame($snowflake->increment, $parsed->increment);
    }

    public function testIdIsAutoIncremented()
    {
        $this->assertTrue($this->maker->nextId() < $this->maker->nextId());
    }
}
