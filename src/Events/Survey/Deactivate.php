<?php

namespace CenoteSolutions\LaravelQualtricsWebhooks\Events\Survey;

use CenoteSolutions\LaravelQualtricsWebhooks\Events\Concerns\WithSurvey;
use CenoteSolutions\LaravelQualtricsWebhooks\Events\NotificationEvent;

class Deativate extends NotificationEvent
{
    use WithSurvey;
}