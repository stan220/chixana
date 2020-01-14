<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    private const WEEKDAYS_RU = ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'];

    public function getFilters()
    {
        return [
            new TwigFilter('weekday', [$this, 'formatWeekday']),
        ];
    }

    public function formatWeekday($weekdayNumber)
    {
        return self::WEEKDAYS_RU[$weekdayNumber];
    }
}
