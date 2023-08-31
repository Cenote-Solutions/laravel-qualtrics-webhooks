<?php

namespace CenoteSolutions\LaravelQualtricsWebhooks\Events\Concerns;

use CenoteSolutions\LaravelQualtricsWebhooks\Support\Date;

trait WithSurveyResponse
{
    use WithSurveySession;

    public function getDateCompleted()
    {
        return $this->getData('CompletedDate');
    }

    public function getDateCompletedAsCarbon()
    {
        return Date::toCarbon($this->getDateCompleted());
    }
}