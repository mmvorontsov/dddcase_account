<?php

namespace App\Presentation\Api\V1\ParamConverter;

use App\Context\Account\Application\UseCase\Command\CreateContactDataChange\{
    CreateContactDataChangeRequest,
};
use App\Context\Account\Domain\Common\Enum\PrimaryContactDataTypeEnum;
use App\Context\Account\Infrastructure\Serialization\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

use function is_string;

/**
 * Class CreateContactDataChangeRequestParamConverter
 * @package App\Presentation\Api\V1\ParamConverter
 */
final class CreateContactDataChangeRequestParamConverter implements ParamConverterInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * CreateContactDataChangeRequestParamConverter constructor.
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

        if (isset($data['type']) && is_string($data['type']) && PrimaryContactDataTypeEnum::isValidKey($data['type'])) {
            $object = $this->serializer->denormalize($data, CreateContactDataChangeRequest::class);
        } else {
            $object = new CreateContactDataChangeRequest();
        }

        $request->attributes->set($configuration->getName(), $object);

        return true;
    }

    /**
     * @param ParamConverter $configuration
     * @return bool
     */
    public function supports(ParamConverter $configuration): bool
    {
        return $configuration->getClass() === CreateContactDataChangeRequest::class;
    }
}
