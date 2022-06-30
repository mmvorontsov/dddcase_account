<?php

namespace App\System\Controller\Development\Preview;

use App\Context\Account\Application\Notification\ContactDataChangeSecretCode\ContactDataChangeSecretCode;
use App\Context\Account\Application\Notification\CredentialRecoverySecretCode\CredentialRecoverySecretCode;
use App\Context\Account\Application\Notification\RegistrationSecretCode\RegistrationSecretCode;
use App\Context\Account\Application\Notification\SuccessfulEmailChange\SuccessfulEmailChange;
use App\Context\Account\Application\Notification\SuccessfulPasswordChange\SuccessfulPasswordChange;
use App\Context\Account\Infrastructure\Adapter\Application\Notification\{
    ContactDataChangeSecretCode\ContactDataChangeSecretCodeEmailSenderInterface,
    CredentialRecoverySecretCode\CredentialRecoverySecretCodeEmailSenderInterface,
    RegistrationSecretCode\RegistrationSecretCodeEmailSenderInterface,
    SuccessfulEmailChange\SuccessfulEmailChangeEmailSenderInterface,
    SuccessfulPasswordChange\SuccessfulPasswordChangeEmailSenderInterface,
};
use App\Context\Account\Infrastructure\Notification\Recipient\EmailNotificationRecipient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EmailPreviewController
 * @package App\System\Controller\Development\Preview
 */
final class EmailPreviewController
{
    /**
     * @Route(
     *     path="/email-preview/registration-secret-code",
     *     methods={"GET"}
     * )
     *
     * @param RegistrationSecretCodeEmailSenderInterface $sender
     * @return Response
     */
    public function registrationSecretCode(RegistrationSecretCodeEmailSenderInterface $sender): Response
    {
        return new Response(
            $sender->renderPreview(
                new RegistrationSecretCode('111333'),
                new EmailNotificationRecipient('email@example.com')
            )
        );
    }

    /**
     * @Route(
     *     path="/email-preview/contact-data-change-secret-code",
     *     methods={"GET"}
     * )
     *
     * @param ContactDataChangeSecretCodeEmailSenderInterface $sender
     * @return Response
     */
    public function contactDataChangeSecretCode(ContactDataChangeSecretCodeEmailSenderInterface $sender): Response
    {
        return new Response(
            $sender->renderPreview(
                new ContactDataChangeSecretCode('111333'),
                new EmailNotificationRecipient('email@example.com')
            )
        );
    }

    /**
     * @Route(
     *     path="/email-preview/credential-recovery-secret-code",
     *     methods={"GET"}
     * )
     *
     * @param CredentialRecoverySecretCodeEmailSenderInterface $sender
     * @return Response
     */
    public function credentialRecoverySecretCode(CredentialRecoverySecretCodeEmailSenderInterface $sender): Response
    {
        return new Response(
            $sender->renderPreview(
                new CredentialRecoverySecretCode('111333'),
                new EmailNotificationRecipient('email@example.com')
            )
        );
    }

    /**
     * @Route(
     *     path="/email-preview/successful-email-change",
     *     methods={"GET"}
     * )
     *
     * @param SuccessfulEmailChangeEmailSenderInterface $sender
     * @return Response
     */
    public function successfulEmailChange(SuccessfulEmailChangeEmailSenderInterface $sender): Response
    {
        return new Response(
            $sender->renderPreview(
                new SuccessfulEmailChange('from@example.com', 'to@example.com'),
                new EmailNotificationRecipient('to@example.com')
            )
        );
    }

    /**
     * @Route(
     *     path="/email-preview/successful-password-change",
     *     methods={"GET"}
     * )
     *
     * @param SuccessfulPasswordChangeEmailSenderInterface $sender
     * @return Response
     */
    public function credentialPasswordUpdated(SuccessfulPasswordChangeEmailSenderInterface $sender): Response
    {
        return new Response(
            $sender->renderPreview(
                new SuccessfulPasswordChange(),
                new EmailNotificationRecipient('email@example.com')
            )
        );
    }
}
