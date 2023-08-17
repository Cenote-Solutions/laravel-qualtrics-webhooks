<?php

namespace CenoteSolutions\LaravelQualtricsWebhooks;

use CenoteSolutions\LaravelQualtricsWebhooks\Events\Factory as EventFactory;
use InvalidArgumentException;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Psr\Log\LoggerInterface;

class WebhooksManager
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var \CenoteSolutions\LaravelQualtricsWebhooks\Events\Factory
     */
    protected $factory;

    /**
     * @var \Illuminate\Routing\UrlGenerator 
     */
    protected $url;

    /**
     * @var \Psr\Log\LoggerInterface|null
     */
    protected $logger;

    /**
     * Create new webhooks manager instance.
     * 
     * @param array $config
     * @param \Illuminate\Routing\UrlGenerator $url
     * @param Psr\Log\LoggerInterface $logger
     */
    public function __construct(array $config, UrlGenerator $url, LoggerInterface $logger)
    {
        $this->factory = new EventFactory($config['events']);
        $this->config = $config;
        $this->url = $url;
        $this->logger = $logger;
    }

    /**
     * Get the event factory.
     * 
     * @return \CenoteSolutions\LaravelQualtricsWebhooks\Events\Factory
     */
    public function events()
    {
        return $this->factory;
    }

    /**
     * Get the publication URL for the given event name.
     * 
     * @param string $event
     * @param array $parameters
     * @return string
     */
    public function publicationUrl($event, array $parameters = [])
    {
        return $this->url->route('qualtrics-webhooks.listen', $parameters);
    }

    /**
     * Get an array of payload for creating event subscriptions for the specified events.
     * 
     * @param array $events
     * @return array
     */
    public function getEventSubscriptionCreatePayloadList(array $events)
    {
        return collect(
            Arr::only($this->config['events'], $events)
        )->mapWithKeys(function ($event) {
            return [
                'publicationUrl' => $this->publicationUrl($event),
                'topics' => $event,
                'event' => $this->
            ];

            return [$event => $payload];
        })->all();
    }

    /**
     * Determine whether the event|topic is listenes or not.
     * 
     * @param string $event
     * @return bool
     */
    public function listens($event)
    {
        return $this->factory->makes($event);
    }

    /**
     * Get the configuration with the specified key.
     * 
     * @param string $key
     * @param mixed $default (optional)
     * @return mixed
     */
    public function getConfig($key, $default = null)
    {
        return Arr::get($this->config, $key, $default);
    }

    /**
     * Determine whether the contents of the request are encrypted or not.
     * 
     * @return bool
     */
    public function encrypted()
    {
        return $this->getConfig('encrypted');
    }

    /**
     * Get the shared key for HMAC message authentication.
     * 
     * @return string|null
     */
    public function sharedKey()
    {
        return $this->getConfig('shared_key');
    }

    /**
     * Determine whether the logging of received events is enabled.
     * 
     * @return bool
     */
    public function logEnabled()
    {
        return false;

        return $this->getConfig('log.enabled');
    }

    /**
     * Log the webhook request (if logging is enabled).
     * 
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function log(Request $request)
    {
        if ($this->logEnabled()) {
            // TODO
            // Get log level from config
            $this->logger->debug($this->formatRequestLog($request));
        }
    }

    /**
     * Format the message that should be logged for the request.
     * 
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    protected function formatRequestLog(Request $request)
    {
        return $request->fullUrlWithQuery();
    }
}