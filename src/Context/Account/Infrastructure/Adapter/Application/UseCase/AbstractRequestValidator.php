<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\UseCase;

use Exception;
use App\Context\Account\Application\Common\Error\ErrorList;
use App\Context\Account\Application\Common\Error\ErrorListInterface;
use App\Context\Account\Application\Common\Error\ValidationError\ValidationError;
use App\Context\Account\Infrastructure\Serialization\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolation as SymfonyConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList as BaseConstraintViolationList;

use function preg_replace_callback;

/**
 * Class AbstractRequestValidator
 * @package App\Context\Account\Infrastructure\Adapter\Application\UseCase
 */
abstract class AbstractRequestValidator
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * AbstractRequestValidator constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param object $request
     * @return array
     * @throws Exception
     */
    protected function requestToArray(object $request): array
    {
        return $this->serializer->normalize($request);
    }

    /**
     * @param BaseConstraintViolationList $constraintViolationList
     * @return ErrorListInterface
     */
    protected function getErrorList(BaseConstraintViolationList $constraintViolationList): ErrorListInterface
    {
        $errorList = new ErrorList();

        /** @var SymfonyConstraintViolation $violation */
        foreach ($constraintViolationList as $violation) {
            $errorList->add(
                new ValidationError(
                    $violation->getMessage(),
                    $this->clearPropertyPath($violation->getPropertyPath()),
                ),
            );
        }

        return $errorList;
    }

    /**
     * @param string $propertyPath
     * @return string
     */
    private function clearPropertyPath(string $propertyPath): string
    {
        $callback = static function (array $matches) {
            return $matches[1];
        };

        return preg_replace_callback('/^\[(\w+)\]/', $callback, $propertyPath);
    }
}
