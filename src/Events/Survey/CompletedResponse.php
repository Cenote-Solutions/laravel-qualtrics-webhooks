<?php

namespace CenoteSolutions\LaravelQualtricsWebhooks\Events\Survey;

use CenoteSolutions\LaravelQualtricsWebhooks\Events\Concerns\WithSurveyResponse;
use CenoteSolutions\LaravelQualtricsWebhooks\Events\NotificationEvent;

class CompletedResponse extends NotificationEvent
{
    use WithSurveyResponse;
}