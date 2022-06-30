<?php

namespace App\Presentation\Api\V1\Controller;

use App\Context\Account\Application\UseCase\Command\CreateRegistration\{
    CreateRegistrationRequest,
    CreateRegistrationResponse,
    CreateRegistrationResponseNormalizerInterface,
    CreateRegistrationUseCase,
};
use App\Context\Account\Application\UseCase\Command\CreateRegistrationSecretCode\{
    CreateRegistrationSecretCodeRequest,
    CreateRegistrationSecretCodeResponse,
    CreateRegistrationSecretCodeResponseNormalizerInterface,
    CreateRegistrationSecretCodeUseCaseInterface,
};
use App\Context\Account\Application\UseCase\Command\SignRegistration\{
    SignRegistrationRequest,
    SignRegistrationResponse,
    SignRegistrationResponseNormalizerInterface,
    SignRegistrationUseCaseInterface,
};
use App\Context\Account\Application\UseCase\Query\RegistrationKeyMaker\{
    RegistrationKeyMakerRequest,
    RegistrationKeyMakerResponse,
    RegistrationKeyMakerResponseNormalizerInterface,
    RegistrationKeyMakerUseCaseInterface,
};
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegistrationController
 * @package App\Presentation\Api\V1\Controller
 */
final class RegistrationController extends AbstractController
{
    /**
     * @Route(
     *     path="/registrations",
     *     methods={"POST"}
     * )
     *
     * @OA\Post(tags={"Registrations"}, summary="Create registration", security={},
     *     @OA\RequestBody(required=true,
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(ref=@Model(type=CreateRegistrationRequest::class, groups={"body"}))
     *         )
     *     ),
     *     @OA\Response(response="201", description="Created",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(type="object", allOf={
     *                 @OA\Schema(ref="#/components/schemas/Success"),
     *                 @OA\Schema(type="object",
     *                     @OA\Property(property="data", ref=@Model(type=CreateRegistrationResponse::class))
     *                 )
     *             })
     *         )
     *     ),
     *     @OA\Response(response="400", ref="#/components/responses/BadRequest"),
     *     @OA\Response(response="422", ref="#/components/responses/UnprocessableEntity")
     * )
     *
     * @ParamConverter(name="request", class=CreateRegistrationRequest::class)
     *
     * @param CreateRegistrationRequest $request
     * @param CreateRegistrationUseCase $useCase
     * @param CreateRegistrationResponseNormalizerInterface $responseNormalizer
     * @return Response
     */
    public function createRegistration(
        CreateRegistrationRequest $request,
        CreateRegistrationUseCase $useCase,
        CreateRegistrationResponseNormalizerInterface $responseNormalizer,
    ): Response {
        $response = $useCase->execute($request);

        return $this->respond(
            $responseNormalizer->toArray($response),
            Response::HTTP_CREATED,
        );
    }

    /**
     * @Route(
     *     path="/registrations/{registrationId}/key-maker",
     *     methods={"GET"},
     *     requirements={
     *         "registrationId"="%app.routing.uuid%"
     *     }
     * )
     *
     * @OA\Get(tags={"Registrations"}, summary="Read registration key maker", security={},
     *     @OA\Parameter(name="registrationId", in="path", required="true",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(response="200", description="OK",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(type="object", allOf={
     *                 @OA\Schema(ref="#/components/schemas/Success"),
     *                 @OA\Schema(type="object",
     *                     @OA\Property(property="data", ref=@Model(type=RegistrationKeyMakerResponse::class))
     *                 )
     *             })
     *         )
     *     ),
     *     @OA\Response(response="400", ref="#/components/responses/BadRequest"),
     *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
     *     @OA\Response(response="422", ref="#/components/responses/UnprocessableEntity")
     * )
     *
     * @param string $registrationId
     * @param RegistrationKeyMakerUseCaseInterface $useCase
     * @param RegistrationKeyMakerResponseNormalizerInterface $responseNormalizer
     * @return Response
     */
    public function readRegistrationKeyMaker(
        string $registrationId,
        RegistrationKeyMakerUseCaseInterface $useCase,
        RegistrationKeyMakerResponseNormalizerInterface $responseNormalizer,
    ): Response {
        $request = new RegistrationKeyMakerRequest();
        $request->setRegistrationId($registrationId);
        $response = $useCase->execute($request);

        return $this->respond(
            $responseNormalizer->toArray($response),
        );
    }

    /**
     * @Route(
     *     path="/registrations/{registrationId}/key-maker/secret-codes",
     *     methods={"POST"},
     *     requirements={
     *         "registrationId"="%app.routing.uuid%"
     *     }
     * )
     *
     * @OA\Post(tags={"Registrations"}, summary="Create secret code of registration key maker", security={},
     *     @OA\Parameter(name="registrationId", in="path", required="true",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(response="201", description="Created",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(type="object", allOf={
     *                 @OA\Schema(ref="#/components/schemas/Success"),
     *                 @OA\Schema(type="object",
     *                     @OA\Property(property="data", ref=@Model(type=CreateRegistrationSecretCodeResponse::class))
     *                 )
     *             })
     *         )
     *     ),
     *     @OA\Response(response="400", ref="#/components/responses/BadRequest"),
     *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
     *     @OA\Response(response="422", ref="#/components/responses/UnprocessableEntity")
     * )
     *
     * @param string $registrationId
     * @param CreateRegistrationSecretCodeUseCaseInterface $useCase
     * @param CreateRegistrationSecretCodeResponseNormalizerInterface $responseNormalizer
     * @return Response
     */
    public function createRegistrationSecretCode(
        string $registrationId,
        CreateRegistrationSecretCodeUseCaseInterface $useCase,
        CreateRegistrationSecretCodeResponseNormalizerInterface $responseNormalizer,
    ): Response {
        $request = new CreateRegistrationSecretCodeRequest();
        $request->setRegistrationId($registrationId);
        $response = $useCase->execute($request);

        return $this->respond(
            $responseNormalizer->toArray($response),
            Response::HTTP_CREATED,
        );
    }

    /**
     * @Route(
     *     path="/registrations/{registrationId}/signing",
     *     methods={"PATCH"},
     *     requirements={
     *         "registrationId"="%app.routing.uuid%"
     *     }
     * )
     *
     * @OA\Patch(tags={"Registrations"}, summary="Sign registration (create user)", security={},
     *     @OA\Parameter(name="registrationId", in="path", required="true",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\RequestBody(required=true,
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(ref=@Model(type=SignRegistrationRequest::class, groups={"body"}))
     *         )
     *     ),
     *     @OA\Response(response="200", description="OK",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(type="object", allOf={
     *                 @OA\Schema(ref="#/components/schemas/Success"),
     *                 @OA\Schema(type="object",
     *                     @OA\Property(property="data", ref=@Model(type=SignRegistrationResponse::class))
     *                 )
     *             })
     *         )
     *     ),
     *     @OA\Response(response="400", ref="#/components/responses/BadRequest"),
     *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
     *     @OA\Response(response="422", ref="#/components/responses/UnprocessableEntity")
     * )
     *
     * @ParamConverter(name="request", class=SignRegistrationRequest::class)
     *
     * @param string $registrationId
     * @param SignRegistrationRequest $request
     * @param SignRegistrationUseCaseInterface $useCase
     * @param SignRegistrationResponseNormalizerInterface $responseNormalizer
     * @return Response
     */
    public function signRegistration(
        string $registrationId,
        SignRegistrationRequest $request,
        SignRegistrationUseCaseInterface $useCase,
        SignRegistrationResponseNormalizerInterface $responseNormalizer,
    ): Response {
        $request->setRegistrationId($registrationId);
        $response = $useCase->execute($request);

        return $this->respond(
            $responseNormalizer->toArray($response),
        );
    }
}
