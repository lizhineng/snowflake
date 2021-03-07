<?php

namespace Zhineng\Snowflake\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Zhineng\Snowflake\Fields\Field;
use Zhineng\Snowflake\Fields\Increment;
use Zhineng\Snowflake\Fields\Timestamp;

class FieldTest extends TestCase
{
    public function testMakeField()
    {
        $field = Field::make('machine_id', 10);
        $this->assertSame('machine_id', $field->name());
        $this->assertSame(10, $field->bits());
        $this->assertSame(1023, $field->max());
        $this->assertSame(0, $field->value());
    }

    public function testMakeFieldWithValue()
    {
        $field = Field::make('machine_id', 10, 1);
        $this->assertSame(1, $field->value());
    }

    public function testCouldNotOverflowValue()
    {
        $this->expectException(InvalidArgumentException::class);
        Field::make('machine_id', 1, 2);
    }

    public function testMakeTimestampField()
    {
        $timestamp = Timestamp::make('timestamp', 42);
        $this->assertSame('timestamp', $timestamp->name());
        $this->assertSame(42, $timestamp->bits());
        $this->assertSame(2 ** 42 - 1, $timestamp->max());
        $this->assertSame($timestamp->now(), $timestamp->value());
    }

    public function testCustomEpochTimeForTimestampField()
    {
        $year2015InMilliseconds = strtotime('2015-01-01 00:00:00') * 1000;

        $timestamp = Timestamp::make('timestamp', 42)
            ->startingFrom($year2015InMilliseconds);

        $this->assertSame($year2015InMilliseconds, $timestamp->epoch());
        $this->assertSame($timestamp->now() - $year2015InMilliseconds, $timestamp->value());
    }

    public function testMakeIncrementField()
    {
        $increment = Increment::make('increment', 12);
        $this->assertSame(0, $increment->value());
        $this->assertSame(1, $increment->value());
    }

    public function testMakeDependentIncrementField()
    {
        $machineId = Field::make('machine_id', 2);
        $increment = Increment::make('increment', 12)->for($machineId);

        $this->assertSame(0, $increment->value());
        $this->assertSame(1, $increment->value());

        $anotherMachineId = Field::make('machine_id', 2, 1);
        $increment->for($anotherMachineId);

        $this->assertSame(0, $increment->value());
        $this->assertSame(1, $increment->value());
    }
}
