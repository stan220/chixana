<?php

namespace App\Service;

use App\Repository\ChixRepository;
use App\Value\ChixBoard;

class BoardService
{

    /** @var ChixRepository */
    private $chixRepository;

    public function __construct(ChixRepository $chixRepository)
    {
        $this->chixRepository = $chixRepository;
    }

    /**
     * @param int $weekNumber
     * @return array
     * @throws \Exception
     */
    public function getWeek($weekNumber = 0): array
    {
        $currentWeekday = (new \DateTime())->format('w');

        $board = [];

        for ($weekday = 1; $weekday <= $currentWeekday; $weekday++) {
            $dayBefore = $currentWeekday - $weekday;
            $date = strtotime("-$dayBefore day");
            $count = $this->chixRepository->getChixCountPerDay($date);
            $board[$weekday] = new ChixBoard($count, $date);
        }

        return $board;
    }
}
