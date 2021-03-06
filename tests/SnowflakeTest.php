<?php

namespace Zhineng\Snowflake\Tests;

use PHPUnit\Framework\TestCase;
use Zhineng\Snowflake\Snowflake;

class SnowflakeTest extends TestCase
{
    protected Snowflake $snowflake;

    protected function setUp(): void
    {
        parent::setUp();

        $this->snowflake = new Snowflake;
    }

    public function testGenerateId()
    {
        $this->assertIsInt($this->snowflake->nextId());
    }

    public function testIdIsAutoIncremented()
    {
        $id1 = $this->snowflake->nextId();
        $id2 = $this->snowflake->nextId();
        $this->assertTrue($id2 > $id1);
    }

    public function testCustomEpochTime()
    {
        $this->snowflake->startingFrom($year2015 = 1420070400000);

        $this->assertSame($year2015, $this->snowflake->epochTimestamp());
    }
}
