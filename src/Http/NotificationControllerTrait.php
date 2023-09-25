<?php

namespace CenoteSolutions\LaravelQualtricsWebhooks\Http;

use CenoteSolutions\LaravelQualtricsWebhooks\WebhooksManager;
use CenoteSolutions\LaravelQualtricsWebhooks\Concerns\VerifiesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

trait NotificationControllerTrait
{
    use VerifiesRequest;

    /**
     * Get the webhooks manager instance.
     * 
     * @return \CenoteSolutions\LaravelQualtricsWebhooks\WebhooksManager
     */
    protected function webhooks()
    {
        if (property_exists($this, 'webhooks') && $this->webhooks instanceof WebhooksManager) {
            return $this->webhooks;
        }

        return App::make(WebhooksManager::class);
    }

    /**
     * Handles the notification from Qualtrics.
     * 
     * @param \Illuminate\Http\Request $request
     * @param array $args
     * @return mixed
     * 
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    public function listen(Request $request)
    {
        $this->webhooks()->log($request);

        // Make sure we're interested in the event/topic.
        $event = $request->input('Topic');

        if (! $this->webhooks()->events()->makes($event)) {
            return $this->accepted();
        }
        
        $eventObject = $this->makeEventObject(
            $event, $this->parseMessage($request), $request
        );

        // Check if there's a specific method to handle the received event.
        // If none, we'll simply fire the event object created.
        $method = $this->getControllerMethodForEvent(
            $this->webhooks()->events()->get($event)
        );

        if (method_exists($this, $method)) {
            $response = $this->{$method}($request, $eventObject);
        } else {
            event($eventObject);
        }

        return $response ?? $this->accepted();
    }
    
    /**
     * Get the "MSG" from the request.
     * 
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    protected function getMessageRaw(Request $request)
    {
        return $request->input('MSG');
    }
    
    /**
     * Parse the body of the request to extract and decode the message.
     * 
     * @param \Illuminate\Http\Request $request
     * @return object
     */
    protected function parseMessage(Request $request)
    {
        $sharedKey = $this->webhooks()->sharedKey();

        if ($this->webhooks()->encrypted()) {
            $message = $this->verifyEncrypted($request, $sharedKey);
        } elseif ($sharedKey) {
            $message = $this->verifyHashed($request, $sharedKey);
        } elseif ($data = $request->input()) {
            return json_decode(json_encode($data));
        } else {
            $this->unverified();
        }

        return json_decode($message, $this->shouldDecodeMessageAsAssociative());
    }

    /**
     * Determine whether the decoded message should be an associative array or not.
     * 
     * @return bool
     */
    protected function shouldDecodeMessageAsAssociative()
    {
        return (bool) $this->webhooks()->getConfig('message_associative');
    }

    /**
     * Get the custom controller method for the event config.
     * 
     * @param string $eventConfig
     * @return string
     */
    protected function getControllerMethodForEvent(array $eventConfig)
    {
        return Str::camel(str_replace('.', '_', $eventConfig['event']));
    }

    /**
     * Make an event object for the given event, data and request.
     * 
     * @param string $event
     * @param object $data
     * @param \Illuminate\Http\Request $request
     * @return \CenoteSolutions\LaravelQualtricsWebhooks\Events\NotificationEvent
     */
    protected function makeEventObject($event, $data, Request $request)
    {
        $class = $this->webhooks()->events()->make($event, $data, $request);

        return new $class($event, $data, $request);
    }
    
    /**
     * Get response for accepted notification request.
     * 
     * @return \Illuminate\Http\Response
     */
    protected function accepted()
    {
        return response()->noContent();
    }
}