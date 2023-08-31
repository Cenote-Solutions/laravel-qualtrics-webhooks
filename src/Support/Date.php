<?php

namespace CenoteSolutions\LaravelQualtricsWebhooks\Support;

use Carbon\Carbon;

class Date
{
    public static function toCarbon($date)
    {
        return Carbon::parse($date)->shiftTimezone('UTC');
    }
}