<?php

namespace CenoteSolutions\LaravelQualtricsWebhooks\Events\Survey;

use CenoteSolutions\LaravelQualtricsWebhooks\Events\Concerns\WithSurvey;
use CenoteSolutions\LaravelQualtricsWebhooks\Events\NotificationEvent;

class Activate extends NotificationEvent
{
    use WithSurvey;
}