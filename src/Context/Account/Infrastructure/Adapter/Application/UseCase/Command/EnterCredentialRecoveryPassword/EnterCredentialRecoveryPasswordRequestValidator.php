<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\UseCase\Command\EnterCredentialRecoveryPassword;

use Exception;
use App\Context\Account\Application\Common\Error\ErrorListInterface;
use App\Context\Account\Application\UseCase\Command\EnterCredentialRecoveryPassword\{
    EnterCredentialRecoveryPasswordRequest,
    EnterCredentialRecoveryPasswordRequestValidatorInterface,
};
use App\Context\Account\Infrastructure\Adapter\Application\UseCase\AbstractRequestValidator;
use App\Context\Account\Infrastructure\Serialization\SerializerInterface;
use App\Context\Account\Infrastructure\Validation\Constraint\Compound;
use App\Context\Account\Infrastructure\Validation\Constraint\Compound\AbstractCompound;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class EnterCredentialRecoveryPasswordRequestValidator
 * @package App\Context\Account\Infrastructure\Adapter\Application\UseCase\Command\EnterCredentialRecoveryPassword
 */
final class EnterCredentialRecoveryPasswordRequestValidator extends AbstractRequestValidator implements
    EnterCredentialRecoveryPasswordRequestValidatorInterface
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * EnterCredentialRecoveryPasswordRequestValidator constructor.
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        parent::__construct($serializer);
        $this->validator = $validator;
    }

    /**
     * @param EnterCredentialRecoveryPasswordRequest $request
     * @return ErrorListInterface
     * @throws Exception
     */
    public function validate(EnterCredentialRecoveryPasswordRequest $request): ErrorListInterface
    {
        $input = $this->requestToArray($request);

        $constraint = new Assert\Collection(
            [
                'fields' => [
                    'credentialRecoveryId' => new Assert\Required([new Compound\UuidCompound()]),
                    'password' => new Assert\Required(
                        [
                            new Compound\PasswordCompound(['payload' => [AbstractCompound::NOT_NULL => []]]),
                        ],
                    ),
                    'passwordEntryCode' => new Assert\Required(
                        [
                            new Assert\NotNull(),
                            new Assert\Type('string'),
                            new Assert\Length(['min' => 40]),
                        ],
                    ),
                ],
                'allowMissingFields' => false,
                'allowExtraFields' => false,
            ]
        );

        return $this->getErrorList(
            $this->validator->validate($input, $constraint),
        );
    }
}
