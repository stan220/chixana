<?php

namespace App\Value;

class ChixBoard
{
    private const FIVE_DIV_VALUE = 5;

    private $fiveCount;

    private $mod;

    private $date;

    public function __construct(int $amount, int $date)
    {
        $this->fiveCount = intdiv($amount, self::FIVE_DIV_VALUE);
        $this->mod = $amount % self::FIVE_DIV_VALUE;
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getFiveCount(): int
    {
        return $this->fiveCount;
    }

    /**
     * @return int
     */
    public function getMod(): int
    {
        return $this->mod;
    }

    /**
     * @return int
     */
    public function getDate(): int
    {
        return $this->date;
    }

}
