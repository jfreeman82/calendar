<?php
namespace Calendar\Modules\Time;


function dmyToTime(string $day = "",string $month = "",string $year = "")
{
    if ($day == "")     { $day      = currentDay();      }
    if ($month == "")   { $month    = currentMonth();    }
    if ($year == "")    { $year     = currentYear();     }

    // check length
    if (strlen($day) == 1)      { $day      = '0'.$day;     }
    if (strlen($month) == 1)    { $month    = '0'.$month;   }
    if (strlen($year) == 2)     { $year     = '20'.$year;   }

    $time = $year.$month.$day;
    return strtotime($time);
}

function validateDate($date): bool
{
    $d = \DateTime::createFromFormat('Ymd', $date);
    return $d && $d->format('Ymd') === $date;
}

function dayNumber($day,$month,$year): int
{
    return date('N',dmyToTime($day,$month,$year));
}

function currentDay() 
{
    return date('d');
}           

function currentMonth()
{
    return date('m');
}

function currentYear()
{
    return date('Y');
}

function fullDay(string $day): string
{
    if (strlen($day) == 1)      { $day      = '0'.$day;     }
    return $day;
}
        