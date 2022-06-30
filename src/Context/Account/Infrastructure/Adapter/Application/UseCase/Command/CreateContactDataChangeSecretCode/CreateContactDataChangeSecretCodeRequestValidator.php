<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\UseCase\Command\CreateContactDataChangeSecretCode;

use App\Context\Account\Application\Common\Error\ErrorListInterface;
use App\Context\Account\Infrastructure\Validation\Constraint\Compound\AbstractCompound;
use App\Context\Account\Application\UseCase\Command\CreateContactDataChangeSecretCode\{
    CreateContactDataChangeSecretCodeRequest,
    CreateContactDataChangeSecretCodeRequestValidatorInterface,
};
use App\Context\Account\Infrastructure\Adapter\Application\UseCase\AbstractRequestValidator;
use App\Context\Account\Infrastructure\Serialization\SerializerInterface;
use App\Context\Account\Infrastructure\Validation\Constraint\Compound;
use Exception;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CreateContactDataChangeSecretCodeRequestValidator
 * @package App\Context\Account\Infrastructure\Adapter\Application\UseCase\Command\CreateContactDataChangeSecretCode
 */
final class CreateContactDataChangeSecretCodeRequestValidator extends AbstractRequestValidator implements
    CreateContactDataChangeSecretCodeRequestValidatorInterface
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * CreateContactDataChangeSecretCodeRequestValidator constructor.
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        parent::__construct($serializer);
        $this->validator = $validator;
    }

    /**
     * @param CreateContactDataChangeSecretCodeRequest $request
     * @return ErrorListInterface
     * @throws Exception
     */
    public function validate(CreateContactDataChangeSecretCodeRequest $request): ErrorListInterface
    {
        $input = $this->requestToArray($request);

        $constraint = new Assert\Collection(
            [
                'fields' => [
                    'contactDataChangeId' => new Assert\Required(
                        [
                            new Compound\UuidCompound(['payload' => [AbstractCompound::NOT_NULL => []]]),
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
