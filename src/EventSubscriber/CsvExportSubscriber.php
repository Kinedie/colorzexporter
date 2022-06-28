<?php

namespace ColorzExporter\EventSubscriber;

use ColorzExporter\EventSubscriber\Event\MembersExportEvent;
use ColorzExporter\EventSubscriber\Event\TeamsExportEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class CsvExportSubscriber implements EventSubscriberInterface
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            TeamsExportEvent::class => 'onTeamsExport',
            MembersExportEvent::class => 'onMembersExport',
        ];
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function onTeamsExport(TeamsExportEvent $teamsExportEvent)
    {
        $email = new Email();
        $email
            ->from('address@gmail.com')
            ->to('superheroes.observatory@gmail.com')
            ->subject('Export of teams')
            ->text('Please find enclosed the latest info on all the superteams.')
            ->attach('public/' . $teamsExportEvent->filename, null, 'text/comma-separated-values');
        $this->mailer->send($email);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function onMembersExport(MembersExportEvent $membersExportEvent)
    {
        $email = new Email();
        $email
            ->from('address@gmail.com')
            ->to('superheroes.observatory@gmail.com')
            ->subject('Export of members')
            ->text('Please find enclosed the latest info on all the superheroes and villains.')
            ->attach('public/' . $membersExportEvent->filename, null, 'text/comma-separated-values');
        $this->mailer->send($email);
    }
}
