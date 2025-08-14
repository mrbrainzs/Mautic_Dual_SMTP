<?php

return [
    'services' => [
        'events' => [
            'mautic.dual_smtp.email_subscriber' => [
                'class' => \MauticPlugin\DualSmtpBundle\EventListener\EmailSubscriber::class,
                'arguments' => [
                    '%dual_smtp.dsn_2%',
                    '%dual_smtp.mailer_from_email%',
                    '%dual_smtp.mailer_reply_to_email%',
                    '%dual_smtp.mailer_return_path%'
                ]
            ],
        ],
        'parameters' => [
            'dual_smtp.dsn_2' => 'smtp://smtp2.example.com',
            'dual_smtp.mailer_from_email' => 'info@crm.datainnovation.io',
            'dual_smtp.mailer_reply_to_email' => 'info@datainnovation.io',
            'dual_smtp.mailer_return_path' => 'info@crm.datainnovation.io',
        ],
    ],
];
