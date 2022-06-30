<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\UseCase\Query\Roles;

use Exception;
use App\Context\Account\Application\Common\Error\ErrorListInterface;
use App\Context\Account\Application\UseCase\Query\Roles\RolesRequest;
use App\Context\Account\Application\UseCase\Query\Roles\RolesRequestValidatorInterface;
use App\Context\Account\Infrastructure\Adapter\Application\UseCase\AbstractRequestValidator;
use App\Context\Account\Infrastructure\Serialization\SerializerInterface;
use App\Context\Account\Infrastructure\Validation\Constraint\Compound;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class RolesRequestValidator
 * @package App\Context\Account\Infrastructure\Adapter\Application\UseCase\Query\Roles
 */
final class RolesRequestValidator extends AbstractRequestValidator implements RolesRequestValidatorInterface
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * RolesRequestValidator constructor.
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        parent::__construct($serializer);
        $this->validator = $validator;
    }

    /**
     * @param RolesRequest $request
     * @return ErrorListInterface
     * @throws Exception
     */
    public function validate(RolesRequest $request): ErrorListInterface
    {
        $input = $this->requestToArray($request);

        $constraint = new Assert\Collection(
            [
                'fields' => [
                    'roleId' => new Assert\Optional(
                        [
                            new Assert\All([new Compound\RoleIdCompound()]),
                        ],
                    ),
                    'owner' => new Assert\Optional(
                        [
                            new Assert\Type('string'),
                            new Assert\Length(['min' => 1]),
                        ],
                    ),
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
