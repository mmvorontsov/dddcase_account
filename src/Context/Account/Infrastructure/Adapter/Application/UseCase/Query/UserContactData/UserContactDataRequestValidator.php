<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\UseCase\Query\UserContactData;

use App\Context\Account\Infrastructure\Validation\Constraint\Compound\AbstractCompound;
use Exception;
use App\Context\Account\Application\Common\Error\ErrorListInterface;
use App\Context\Account\Application\UseCase\Query\UserContactData\{
    UserContactDataRequest,
    UserContactDataRequestValidatorInterface,
};
use App\Context\Account\Infrastructure\Adapter\Application\UseCase\AbstractRequestValidator;
use App\Context\Account\Infrastructure\Serialization\SerializerInterface;
use App\Context\Account\Infrastructure\Validation\Constraint\Compound;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UserContactDataRequestValidator
 * @package App\Context\Account\Infrastructure\Adapter\Application\UseCase\Query\UserContactData
 */
final class UserContactDataRequestValidator extends AbstractRequestValidator implements
    UserContactDataRequestValidatorInterface
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * UserContactDataRequestValidator constructor.
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        parent::__construct($serializer);
        $this->validator = $validator;
    }

    /**
     * @param UserContactDataRequest $request
     * @return ErrorListInterface
     * @throws Exception
     */
    public function validate(UserContactDataRequest $request): ErrorListInterface
    {
        $input = $this->requestToArray($request);

        $constraint = new Assert\Collection(
            [
                'fields' => [
                    'userId' => new Assert\Required(
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
