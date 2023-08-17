<?php

namespace CenoteSolutions\LaravelQualtricsWebhooks\Http;

use CenoteSolutions\LaravelQualtricsWebhooks\WebhooksManager;
use Illuminate\Routing\Controller;

class NotificationController extends Controller
{
    use NotificationControllerTrait;

    /**
     * @var \CenoteSolutions\LaravelQualtricsWebhooks\WebhooksManager|null
     */
    protected $webhooks;

    /**
     * Create new instance of notification controller.
     * 
     *  @var \CenoteSolutions\LaravelQualtricsWebhooks\WebhooksManager $webhooks
     */
    public function __construct(WebhooksManager $webhooks)
    {
        $this->webhooks = $webhooks;
    }
}