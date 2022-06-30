<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\UseCase\Query\Users;

use Exception;
use App\Context\Account\Application\Common\Error\ErrorListInterface;
use App\Context\Account\Application\UseCase\Query\Users\UsersRequest;
use App\Context\Account\Application\UseCase\Query\Users\UsersRequestValidatorInterface;
use App\Context\Account\Infrastructure\Adapter\Application\UseCase\AbstractRequestValidator;
use App\Context\Account\Infrastructure\Serialization\SerializerInterface;
use App\Context\Account\Infrastructure\Validation\Constraint\Compound;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UsersRequestValidator
 * @package App\Context\Account\Infrastructure\Adapter\Application\UseCase\Query\Users
 */
final class UsersRequestValidator extends AbstractRequestValidator implements UsersRequestValidatorInterface
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * UsersRequestValidator constructor.
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        parent::__construct($serializer);
        $this->validator = $validator;
    }

    /**
     * @param UsersRequest $request
     * @return ErrorListInterface
     * @throws Exception
     */
    public function validate(UsersRequest $request): ErrorListInterface
    {
        $input = $this->requestToArray($request);

        $constraint = new Assert\Collection(
            [
                'fields' => [
                    'userId' => new Assert\Optional(
                        [
                            new Assert\All([new Compound\UuidCompound()]),
                        ],
                    ),
                    'firstname' => new Assert\Optional([new Compound\FirstnameCompound()]),
                    'page' => new Assert\Optional([new Compound\PageCompound()]),
                    'limit' => new Assert\Optional([new Compound\LimitCompound()]),
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
