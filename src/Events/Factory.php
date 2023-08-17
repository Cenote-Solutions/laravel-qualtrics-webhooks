<?php

namespace CenoteSolutions\LaravelQualtricsWebhooks\Events;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use InvalidArgumentException;

class Factory
{
    protected $events;

    public function __construct(array $events)
    {
        $this->events = new Collection($events);
    }

    public function make($event, $data, Request $request)
    {
        $config = $this->get($event);

        if (! $config) {
            throw new InvalidArgumentException("Cannot find a match for event $event");
        }

        $class = $config['class'];

        return new $class($event, $data, $request);
    }

    public function makes($event)
    {
        return $this->get($event) !== null;
    }

    /**
     * Get the details/configuration for the event.
     * 
     * @param string $event
     * @return array|null
     */
    public function get($event)
    {
        return $this->events->first(function ($config) use ($event) {
            return $this->matchesName($event, $config['event']);
        });
    }

    protected function matchesName($event, $pattern)
    {
        return (
            $pattern === '*'
            || $event === $pattern 
            || Str::startsWith($event, "$pattern.")
        );
    }
}