<?php

namespace Zhineng\Snowflake;

class Snowflake
{
    protected int $timestampBits = 42;

    protected int $workerIdBits = 5;

    protected int $processIdBits = 5;

    protected int $incrementBits = 12;

    protected int $epochTimestamp = 0;

    protected ?int $lastTimestamp = null;

    protected int $increment = 0;

    public function __construct(
        protected int $workerId = 0,
        protected int $processId = 0
    )
    {
        //
    }

    protected function currentTimestamp(): int
    {
        return intval(microtime(true) * 1000);
    }

    public function startingFrom(int $timestamp): self
    {
        $this->epochTimestamp = $timestamp;

        return $this;
    }

    public function epochTimestamp(): int
    {
        return $this->epochTimestamp;
    }

    public function timestamp(): int
    {
        return $this->currentTimestamp() - $this->epochTimestamp();
    }

    public function timestampBits(): int
    {
        return $this->timestampBits;
    }

    protected function workerId()
    {
        return $this->workerId;
    }

    public function workerIdBits(): int
    {
        return $this->workerIdBits;
    }

    protected function processId()
    {
        return $this->processId;
    }

    public function processIdBits(): int
    {
        return $this->processIdBits;
    }

    protected function sequenceFor(int $timestamp): int
    {
        if ($timestamp === $this->lastTimestamp) {
            return ++$this->increment;
        }

        $this->lastTimestamp = $timestamp;

        return $this->increment = 0;
    }

    public function incrementBits(): int
    {
        return $this->incrementBits;
    }

    public function timestampOffsetBits(): int
    {
        return $this->workerIdBits() + $this->processIdBits() + $this->incrementBits();
    }

    public function workerIdOffsetBits(): int
    {
        return $this->processIdBits() + $this->incrementBits();
    }

    public function processIdOffsetBits(): int
    {
        return $this->incrementBits();
    }

    public function nextId(): int
    {
        return ($timestamp = $this->timestamp()) << $this->timestampOffsetBits()
            | $this->workerId() << $this->workerIdOffsetBits()
            | $this->processId() << $this->processIdOffsetBits()
            | $this->sequenceFor($timestamp);
    }
}
