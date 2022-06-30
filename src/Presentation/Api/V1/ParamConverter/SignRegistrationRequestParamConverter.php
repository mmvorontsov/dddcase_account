<?php

namespace App\Presentation\Api\V1\ParamConverter;

use App\Context\Account\Application\UseCase\Command\SignRegistration\SignRegistrationRequest;
use App\Context\Account\Infrastructure\Serialization\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SignRegistrationRequestParamConverter
 * @package App\Presentation\Api\V1\ParamConverter
 */
final class SignRegistrationRequestParamConverter implements ParamConverterInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * SignRegistrationRequestParamConverter constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param Request $request
     * @param ParamConverter $configuration
     * @return bool
     */
    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $data = $request->request->all();
        $object = $this->serializer->denormalize($data, SignRegistrationRequest::class);
        $request->attributes->set($configuration->getName(), $object);

        return true;
    }

    /**
     * @param ParamConverter $configuration
     * @return bool
     */
    public function supports(ParamConverter $configuration): bool
    {
        return $configuration->getClass() === SignRegistrationRequest::class;
    }
}
