<?php

namespace App\System\Controller\Development\Preview;

use App\Context\Account\Application\Notification\ContactDataChangeSecretCode\ContactDataChangeSecretCode;
use App\Context\Account\Application\Notification\CredentialRecoverySecretCode\CredentialRecoverySecretCode;
use App\Context\Account\Application\Notification\RegistrationSecretCode\RegistrationSecretCode;
use App\Context\Account\Application\Notification\SuccessfulPasswordChange\SuccessfulPasswordChange;
use App\Context\Account\Application\Notification\SuccessfulPhoneChange\SuccessfulPhoneChange;
use App\Context\Account\Infrastructure\Adapter\Application\Notification\{
    ContactDataChangeSecretCode\ContactDataChangeSecretCodeSmsSenderInterface,
    CredentialRecoverySecretCode\CredentialRecoverySecretCodeSmsSenderInterface,
    RegistrationSecretCode\RegistrationSecretCodeSmsSenderInterface,
    SuccessfulPasswordChange\SuccessfulPasswordChangeSmsSenderInterface,
    SuccessfulPhoneChange\SuccessfulPhoneChangeSmsSenderInterface,
};
use App\Context\Account\Infrastructure\Notification\Recipient\SmsNotificationRecipient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SmsPreviewController
 * @package App\System\Controller\Development\Preview
 */
final class SmsPreviewController
{
    /**
     * @Route(
     *     path="/sms-preview/registration-secret-code",
     *     methods={"GET"}
     * )
     *
     * @param RegistrationSecretCodeSmsSenderInterface $sender
     * @return Response
     */
    public function registrationSecretCode(RegistrationSecretCodeSmsSenderInterface $sender): Response
    {
        return new Response(
            $sender->renderSmsPreview(
                new RegistrationSecretCode('333555'),
                new SmsNotificationRecipient('+12345678901')
            )
        );
    }

    /**
     * @Route(
     *     path="/sms-preview/contact-data-change-secret-code",
     *     methods={"GET"}
     * )
     *
     * @param ContactDataChangeSecretCodeSmsSenderInterface $sender
     * @return Response
     */
    public function contactDataChangeSecretCode(ContactDataChangeSecretCodeSmsSenderInterface $sender): Response
    {
        return new Response(
            $sender->renderPreview(
                new ContactDataChangeSecretCode('333555'),
                new SmsNotificationRecipient('+12345678901')
            )
        );
    }


    /**
     * @Route(
     *     path="/sms-preview/credential-recovery-secret-code",
     *     methods={"GET"}
     * )
     *
     * @param CredentialRecoverySecretCodeSmsSenderInterface $sender
     * @return Response
     */
    public function credentialRecoverySecretCode(CredentialRecoverySecretCodeSmsSenderInterface $sender): Response
    {
        return new Response(
            $sender->renderPreview(
                new CredentialRecoverySecretCode('333555'),
                new SmsNotificationRecipient('+12345678901')
            )
        );
    }

    /**
     * @Route(
     *     path="/sms-preview/successful-phone-change",
     *     methods={"GET"}
     * )
     *
     * @param SuccessfulPhoneChangeSmsSenderInterface $sender
     * @return Response
     */
    public function successfulPhoneChange(SuccessfulPhoneChangeSmsSenderInterface $sender): Response
    {
        return new Response(
            $sender->renderPreview(
                new SuccessfulPhoneChange('+12345678901', '+12345678910'),
                new SmsNotificationRecipient('+12345678910')
            )
        );
    }

    /**
     * @Route(
     *     path="/sms-preview/successful-password-change",
     *     methods={"GET"}
     * )
     *
     * @param SuccessfulPasswordChangeSmsSenderInterface $sender
     * @return Response
     */
    public function successfulPasswordChange(SuccessfulPasswordChangeSmsSenderInterface $sender): Response
    {
        return new Response(
            $sender->renderPreview(
                new SuccessfulPasswordChange(),
                new SmsNotificationRecipient('+12345678910')
            )
        );
    }
}
