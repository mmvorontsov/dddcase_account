<?php

namespace App\Presentation\Api\V1\ParamConverter;

use App\Context\Account\Application\UseCase\Query\Roles\RolesRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class RolesRequestParamConverter
 * @package App\Presentation\Api\V1\ParamConverter
 */
final class RolesRequestParamConverter implements ParamConverterInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * RolesRequestParamConverter constructor.
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
        $jsonQuery = $request->query->get('jsonQuery');
        $jsonQuery = empty($jsonQuery) ? '{}' : $jsonQuery;
        $object = $this->serializer->deserialize($jsonQuery, RolesRequest::class, 'json');
        $request->attributes->set($configuration->getName(), $object);

        return true;
    }

    /**
     * @param ParamConverter $configuration
     * @return bool
     */
    public function supports(ParamConverter $configuration): bool
    {
        return $configuration->getClass() === RolesRequest::class;
    }
}
