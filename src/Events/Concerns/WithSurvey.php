<?php

namespace CenoteSolutions\LaravelQualtricsWebhooks\Events\Concerns;

trait WithSurvey
{
    public function getSurveyId()
    {
        return $this->getData('SurveyID');
    }
}