<?php

return [
    'services' => [
        'events' => [
            'mautic.dual_smtp.email_subscriber' => [
                'class' => \MauticPlugin\DualSmtpBundle\EventListener\EmailSubscriber::class,
                'arguments' => [
                    '%dual_smtp.dsn_2%'
                ]
            ],
        ],
        'parameters' => [
            'dual_smtp.dsn_2' => 'smtp://smtp2.example.com',
        ],
    ],
];
