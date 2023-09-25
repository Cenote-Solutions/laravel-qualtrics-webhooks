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
    
    public function isTest()
    {
        return $this->isTruthy($this->getData('IsTest'));
    }

    public function isPreview()
    {
        return $this->isTruthy($this->getData('IsPreview'));
    }

    protected function isTruthy($value)
    {
        return in_array($value, ['true', true, 1, '1'], true);
    }
}