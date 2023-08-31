<?php

namespace CenoteSolutions\LaravelQualtricsWebhooks\Events\Concerns;

use CenoteSolutions\LaravelQualtricsWebhooks\Support\Date;

trait WithSurveySession
{
    use WithSurvey;

    public function getDistributionId()
    {
        return $this->getData('DistributionID');
    }

    public function getRecipientId()
    {
        return $this->getData('RecipientID');
    }

    public function getResponseId()
    {
        return $this->getData('ResponseID');
    }

    public function getStatus()
    {
        return $this->getData('Status');
    }

    public function getDateStarted()
    {
        return $this->getData('StartedDate');
    }

    public function getDateStartedAsCarbon()
    {
        return Date::toCarbon($this->getStartDate());
    }
}