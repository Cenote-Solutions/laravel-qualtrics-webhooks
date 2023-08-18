<?php

$webhooks = app('qualtrics-webhooks');

Route::prefix($webhooks->getConfig('prefix'))
    ->as('qualtrics-webhooks.')
    ->group(function () use ($webhooks) { 

        $controller = $webhooks->getConfig('controller');

        Route::match(['get','post'], 'listen', "$controller@listen")->name('listen');
    });