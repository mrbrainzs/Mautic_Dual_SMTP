<?php

namespace MauticPlugin\DualSmtpBundle\EventListener;

use Mautic\EmailBundle\EmailEvents;
use Mautic\EmailBundle\Event\EmailSendEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Transport;

/**
 * Switches the mail transport based on a contact's custom field named `smtp`.
 * If the field value is "2" then the custom transport DSN is used. Any other
 * value leaves the default transport untouched.
 */
class EmailSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private string $dsn2,
        private string $fromEmail,
        private string $replyToEmail,
        private string $returnPath
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            EmailEvents::EMAIL_ON_SEND => ['onEmailSend', 0],
        ];
    }

    public function onEmailSend(EmailSendEvent $event): void
    {
        $lead = $event->getLead();
        if (empty($lead)) {
            return;
        }

        $smtpValue = null;
        if (is_array($lead)) {
            $smtpValue = $lead['smtp'] ?? null;
        } elseif (method_exists($lead, 'getFieldValue')) {
            $smtpValue = $lead->getFieldValue('smtp');
        }

        if ('2' !== (string) $smtpValue) {
            return;
        }

        $transport = Transport::fromDsn($this->dsn2);

        $helper = $event->getHelper();
        if (null === $helper) {
            return;
        }

        $helper->setFrom($this->fromEmail);
        $helper->setReplyTo($this->replyToEmail);
        $helper->setReturnPath($this->returnPath);

        // Overwrite the MailHelper's transport through reflection
        $refClass = new \ReflectionClass($helper);
        if ($refClass->hasProperty('transport')) {
            $property = $refClass->getProperty('transport');
            $property->setAccessible(true);
            $property->setValue($helper, $transport);
        }
    }
}
