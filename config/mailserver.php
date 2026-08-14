<?php

return [
    'cli_enabled' => env('MAILSERVER_CLI_ENABLED', false),
    'container'   => env('MAILSERVER_CONTAINER', 'mailserver'),
    'use_sudo'    => env('MAILSERVER_USE_SUDO', true),
];
