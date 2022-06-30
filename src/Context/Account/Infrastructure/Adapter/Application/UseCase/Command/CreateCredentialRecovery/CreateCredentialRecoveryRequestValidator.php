<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\UseCase\Command\CreateCredentialRecovery;

use App\Context\Account\Infrastructure\Validation\Constraint\Compound\AbstractCompound;
use Exception;
use App\Context\Account\Application\Common\Error\ErrorListInterface;
use App\Context\Account\Application\UseCase\Command\CreateCredentialRecovery\{
    CreateCredentialRecoveryRequest,
    CreateCredentialRecoveryRequestValidatorInterface,
};
use App\Context\Account\Domain\Common\Enum\PrimaryContactDataTypeEnum;
use App\Context\Account\Infrastructure\Adapter\Application\UseCase\AbstractRequestValidator;
use App\Context\Account\Infrastructure\Serialization\SerializerInterface;
use App\Context\Account\Infrastructure\Validation\Constraint\Compound;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use function array_merge;

/**
 * Class CreateCredentialRecoveryRequestValidator
 * @package App\Context\Account\Infrastructure\Adapter\Application\UseCase\Command\CreateCredentialRecovery
 */
final class CreateCredentialRecoveryRequestValidator extends AbstractRequestValidator implements
    CreateCredentialRecoveryRequestValidatorInterface
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * CreateCredentialRecoveryRequestValidator constructor.
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        parent::__construct($serializer);
        $this->validator = $validator;
    }

    /**
     * @param CreateCredentialRecoveryRequest $request
     * @return ErrorListInterface
     * @throws Exception
     */
    public function validate(CreateCredentialRecoveryRequest $request): ErrorListInterface
    {
        $input = $this->requestToArray($request);

        $errorList = $this->validateDiscriminator($input);
        if ($errorList->hasErrors()) {
            return $errorList;
        }

        return $this->validateAll($request->getType(), $input);
    }

    /**
     * @param array $input
     * @return ErrorListInterface
     */
    private function validateDiscriminator(array $input): ErrorListInterface
    {
        $discriminatorRules = $this->getDiscriminatorRules();
        $constraints = new Assert\Collection(
            [
                'fields' => $discriminatorRules,
                'allowMissingFields' => false,
                'allowExtraFields' => true,
            ],
        );

        return $this->getErrorList(
            $this->validator->validate($input, $constraints),
        );
    }

    /**
     * @param string $discriminator
     * @param array $input
     * @return ErrorListInterface
     */
    private function validateAll(string $discriminator, array $input): ErrorListInterface
    {
        $discriminatorRules = $this->getDiscriminatorRules();
        $primaryDataRules = $this->getPrimaryDataRules($discriminator);
        $constraints = new Assert\Collection(
            [
                'fields' => array_merge($discriminatorRules, $primaryDataRules),
                'allowMissingFields' => false,
                'allowExtraFields' => false,
            ],
        );

        return $this->getErrorList(
            $this->validator->validate($input, $constraints),
        );
    }

    /**
     * @return Assert\Required[]
     */
    private function getDiscriminatorRules(): array
    {
        return [
            'type' => new Assert\Required(
                [
                    new Assert\NotNull(),
                    new Assert\Type('string'),
                    new Assert\Choice(['choices' => PrimaryContactDataTypeEnum::toArray()]),
                ],
            ),
        ];
    }

    /**
     * @param string $type
     * @return array
     */
    private function getPrimaryDataRules(string $type): array
    {
        return match ($type) {
            PrimaryContactDataTypeEnum::EMAIL => [
                'byEmail' => new Assert\Required(
                    [
                        new Compound\EmailCompound(['payload' => [AbstractCompound::NOT_NULL => []]]),
                    ],
                ),
            ],
            PrimaryContactDataTypeEnum::PHONE => [
                'byPhone' => new Assert\Required(
                    [
                        new Compound\PhoneCompound(['payload' => [AbstractCompound::NOT_NULL => []]]),
                    ],
                ),
            ],
            default => [],
        };
    }
}
