<?php

namespace CenoteSolutions\LaravelQualtricsWebhooks\Events;

use Illuminate\Http\Request;

class NotificationEvent
{
    /**
     * @var string
     */
    public $event;

    /**
     * @var array
     */
    public $data;

    /**
     * @var \Illuminate\Http\Request
     */
    public $request;

    /**
     * Create new event instance.
     * 
     * @param string $event
     * @param object $data
     * @param \Illuminate\Http\Request $request
     */
    public function __construct($event, $data, Request $request)
    {
        $this->event = $event;
        $this->data = $data;
        $this->request = $request;
    }

    public function getData($key, $default = null)
    {
        return data_get($this->data, $key, $default);
    }
}