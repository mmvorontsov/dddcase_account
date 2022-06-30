<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\UseCase\Command\UpdateUserRoles;

use App\Context\Account\Infrastructure\Validation\Constraint\Compound\AbstractCompound;
use Exception;
use App\Context\Account\Application\Common\Error\ErrorListInterface;
use App\Context\Account\Application\UseCase\Command\UpdateUserRoles\UpdateUserRolesRequest;
use App\Context\Account\Application\UseCase\Command\UpdateUserRoles\UpdateUserRolesRequestValidatorInterface;
use App\Context\Account\Infrastructure\Adapter\Application\UseCase\AbstractRequestValidator;
use App\Context\Account\Infrastructure\Serialization\SerializerInterface;
use App\Context\Account\Infrastructure\Validation\Constraint\Compound;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UpdateUserRolesRequestValidator
 * @package App\Context\Account\Infrastructure\Adapter\Application\UseCase\Command\UpdateUserRoles
 */
final class UpdateUserRolesRequestValidator extends AbstractRequestValidator implements
    UpdateUserRolesRequestValidatorInterface
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * UpdateUserRolesRequestValidator constructor.
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        parent::__construct($serializer);
        $this->validator = $validator;
    }

    /**
     * @param UpdateUserRolesRequest $request
     * @return ErrorListInterface
     * @throws Exception
     */
    public function validate(UpdateUserRolesRequest $request): ErrorListInterface
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
                    'roleIds' => new Assert\Required(
                        [
                            new Assert\NotNull(),
                            new Assert\All(
                                [
                                    new Compound\RoleIdCompound(),
                                ],
                            ),
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
