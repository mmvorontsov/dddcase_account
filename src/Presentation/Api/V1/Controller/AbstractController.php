<?php

namespace App\Presentation\Api\V1\Controller;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class AbstractController
 * @package App\Presentation\Api\V1\Controller
 */
abstract class AbstractController
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * @var RequestStack
     */
    private RequestStack $requestStack;

    /**
     * AbstractController constructor.
     * @param SerializerInterface $serializer
     * @param RequestStack $requestStack
     */
    public function __construct(SerializerInterface $serializer, RequestStack $requestStack)
    {
        $this->serializer = $serializer;
        $this->requestStack = $requestStack;
    }

    /**
     * @param array $data
     * @param int $status
     * @param array $headers
     * @return Response
     */
    protected function respond(array $data, int $status = Response::HTTP_OK, array $headers = []): Response
    {
        $request = $this->requestStack->getCurrentRequest();
        $format = $request->getRequestFormat();
        $headers['Content-Type'] = $request->getMimeType($format);

        $content = [
            'code' => $status,
            'data' => $data,
        ];

        return new Response($this->serializer->serialize($content, $format), $status, $headers);
    }
}
