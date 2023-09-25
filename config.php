<?php

return [

    /**
     * Prefix for the routes. Rarely changed but useful if prefix isn't available.
     */
    'prefix' => 'qualtrics-wh',

    /**
     * The base URL for publication URLs. Can be changed to an external URL (useful for testing).
     */
    'url' => env('QUALTRICS_WEBHOOKS_URL', null),

    /**
     * Set to true to encrypt the request.
     */
    'encrypted' => env('QUALTRICS_WEBHOOKS_ENCRYPTED', false),

    /**
     * The key to use when decrypting the request body from the notification when "encrypt" is true. 
     */
    'shared_key' => env('QUALTRICS_WEBHOOKS_SHARED_KEY', null),

    /**
     * Whether the JSON decoded message should be an associative array or not.
     */
    'message_associative' => env('QUALTRICS_WEBHOOKS_MESSAGE_ASSOCIATIVE', true),

    /**
     * Events that we are listening to.
     * Each entry must contain the following keys:
     *    event: The name of event in Qualtrics
     *    event_class: The name of the event object that will be fired/dispatched
     *    path: The path to be used in routing. Allowed characters are alphabet, numbers, dash, and underscores.
     */
    'events' => [
        [
            'event' => 'controlpanel.activateSurvey',
            'class' => \CenoteSolutions\LaravelQualtricsWebhooks\Events\Survey\Activate::class
        ],
        [
            'event' => 'controlpanel.deactivateSurvey',
            'class' => \CenoteSolutions\LaravelQualtricsWebhooks\Events\Survey\Deactivate::class
        ],            
        [
            'event' => 'surveyengine.startedRecipientSession',
            'class' => \CenoteSolutions\LaravelQualtricsWebhooks\Events\Survey\StartedRecipientSession::class
        ],
        [
            'event' => 'surveyengine.partialResponse',
            'class' => \CenoteSolutions\LaravelQualtricsWebhooks\Events\Survey\PartialResponse::class
        ],
        [
            'event' => 'surveyengine.completedResponse',
            'class' => \CenoteSolutions\LaravelQualtricsWebhooks\Events\Survey\CompletedResponse::class
        ],
        [
            'event' => '*',
            'class' => \CenoteSolutions\LaravelQualtricsWebhooks\Events\NotificationEvent::class
        ]
    ],

    /**
     * The controller to handle the notification.
     * Can be changed to a class but it should extend the default controller.
     * 
     * See \CenoteSolutions\LaravelQualtricsWebhooks\Http\NotificationController for additional info.
     */
    'controller' => CenoteSolutions\LaravelQualtricsWebhooks\Http\NotificationController::class,

    'log' => [
        'enabled' => env('QUALTRICS_WEBHOOKS_LOG', false),

        'channel' => env('QUALTRICS_WEBHOOKS_LOG_CHANNEL')
    ]

];