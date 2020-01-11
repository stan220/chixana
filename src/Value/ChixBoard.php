<?php

namespace App\Value;

class ChixBoard
{
    private const FIVE_DIV_VALUE = 5;

    private $fiveCount;

    private $mod;

    public function __construct($amount)
    {
        $this->fiveCount = intdiv($amount, self::FIVE_DIV_VALUE);
        $this->mod = $amount % self::FIVE_DIV_VALUE;
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

}
