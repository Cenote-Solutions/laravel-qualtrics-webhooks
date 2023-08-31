<?php

namespace CenoteSolutions\LaravelQualtricsWebhooks\Events\Survey;

use CenoteSolutions\LaravelQualtricsWebhooks\Events\Concerns\WithSurveySession;
use CenoteSolutions\LaravelQualtricsWebhooks\Events\NotificationEvent;

class StartedRecipientSession extends NotificationEvent
{
    use WithSurveySession;
}