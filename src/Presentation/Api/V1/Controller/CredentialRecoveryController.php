<?php

namespace App\Presentation\Api\V1\Controller;

use App\Context\Account\Application\UseCase\Command\CreateCredentialRecovery\{
    CreateCredentialRecoveryRequest,
    CreateCredentialRecoveryResponse,
    CreateCredentialRecoveryResponseNormalizerInterface,
    CreateCredentialRecoveryUseCaseInterface,
    Request\CreateCredentialRecoveryByEmailRequest,
    Request\CreateCredentialRecoveryByPhoneRequest,
};
use App\Context\Account\Application\UseCase\Command\CreateCredentialRecoverySecretCode\{
    CreateCredentialRecoverySecretCodeRequest,
    CreateCredentialRecoverySecretCodeResponse,
    CreateCredentialRecoverySecretCodeResponseNormalizerInterface,
    CreateCredentialRecoverySecretCodeUseCaseInterface,
};
use App\Context\Account\Application\UseCase\Command\EnterCredentialRecoveryPassword\{
    EnterCredentialRecoveryPasswordRequest,
    EnterCredentialRecoveryPasswordResponse,
    EnterCredentialRecoveryPasswordResponseNormalizerInterface,
    EnterCredentialRecoveryPasswordUseCaseInterface,
};
use App\Context\Account\Application\UseCase\Command\SignCredentialRecovery\{
    SignCredentialRecoveryRequest,
    SignCredentialRecoveryResponse,
    SignCredentialRecoveryResponseNormalizerInterface,
    SignCredentialRecoveryUseCaseInterface,
};
use App\Context\Account\Application\UseCase\Query\CredentialRecoveryKeyMaker\{
    CredentialRecoveryKeyMakerRequest,
    CredentialRecoveryKeyMakerResponse,
    CredentialRecoveryKeyMakerResponseNormalizerInterface,
    CredentialRecoveryKeyMakerUseCaseInterface,
};
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CredentialRecoveryController
 * @package App\Presentation\Api\V1\Controller
 */
final class CredentialRecoveryController extends AbstractController
{
    /**
     * @Route(
     *     path="/credential-recoveries",
     *     methods={"POST"}
     * )
     *
     * @OA\Post(tags={"Credential Recoveries"}, summary="Create credential recovery", security={},
     *     @OA\RequestBody(required=true,
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(
     *                 example={"type": "EMAIL", "byEmail": "email@example.com"},
     *                 oneOf={
     *                     @OA\Schema(ref=@Model(type=CreateCredentialRecoveryByEmailRequest::class, groups={"body"})),
     *                     @OA\Schema(ref=@Model(type=CreateCredentialRecoveryByPhoneRequest::class, groups={"body"})),
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(response="201", description="Created",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(type="object", allOf={
     *                 @OA\Schema(ref="#/components/schemas/Success"),
     *                 @OA\Schema(type="object",
     *                     @OA\Property(property="data", ref=@Model(type=CreateCredentialRecoveryResponse::class))
     *                 )
     *             })
     *         )
     *     ),
     *     @OA\Response(response="400", ref="#/components/responses/BadRequest"),
     *     @OA\Response(response="422", ref="#/components/responses/UnprocessableEntity")
     * )
     *
     * @ParamConverter(name="request", class=CreateCredentialRecoveryRequest::class)
     *
     * @param CreateCredentialRecoveryRequest $request
     * @param CreateCredentialRecoveryUseCaseInterface $useCase
     * @param CreateCredentialRecoveryResponseNormalizerInterface $responseNormalizer
     * @return Response
     */
    public function createCredentialRecovery(
        CreateCredentialRecoveryRequest $request,
        CreateCredentialRecoveryUseCaseInterface $useCase,
        CreateCredentialRecoveryResponseNormalizerInterface $responseNormalizer,
    ): Response {
        $response = $useCase->execute($request);

        return $this->respond(
            $responseNormalizer->toArray($response),
            Response::HTTP_CREATED,
        );
    }

    /**
     * @Route(
     *     path="/credential-recoveries/{credentialRecoveryId}/key-maker",
     *     methods={"GET"},
     *     requirements={
     *         "credentialRecoveryId"="%app.routing.uuid%"
     *     }
     * )
     *
     * @OA\Get(tags={"Credential Recoveries"}, summary="Read credential recovery key maker", security={},
     *     @OA\Parameter(name="credentialRecoveryId", in="path", required="true",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(response="200", description="OK",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(type="object", allOf={
     *                 @OA\Schema(ref="#/components/schemas/Success"),
     *                 @OA\Schema(type="object",
     *                     @OA\Property(property="data", ref=@Model(type=CredentialRecoveryKeyMakerResponse::class))
     *                 )
     *             })
     *         )
     *     ),
     *     @OA\Response(response="400", ref="#/components/responses/BadRequest"),
     *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
     *     @OA\Response(response="422", ref="#/components/responses/UnprocessableEntity")
     * )
     *
     * @param string $credentialRecoveryId
     * @param CredentialRecoveryKeyMakerUseCaseInterface $useCase
     * @param CredentialRecoveryKeyMakerResponseNormalizerInterface $responseNormalizer
     * @return Response
     */
    public function readCredentialRecoveryKeyMaker(
        string $credentialRecoveryId,
        CredentialRecoveryKeyMakerUseCaseInterface $useCase,
        CredentialRecoveryKeyMakerResponseNormalizerInterface $responseNormalizer,
    ): Response {
        $request = new CredentialRecoveryKeyMakerRequest();
        $request->setCredentialRecoveryId($credentialRecoveryId);
        $response = $useCase->execute($request);

        return $this->respond(
            $responseNormalizer->toArray($response),
        );
    }

    /**
     * @Route(
     *     path="/credential-recoveries/{credentialRecoveryId}/key-maker/secret-codes",
     *     methods={"POST"},
     *     requirements={
     *         "credentialRecoveryId"="%app.routing.uuid%"
     *     }
     * )
     *
     * @OA\Post(
     *     tags={"Credential Recoveries"},
     *     summary="Create secret code of credential recovery key maker", security={},
     *     @OA\Parameter(name="credentialRecoveryId", in="path", required="true",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(response="201", description="Created",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(type="object", allOf={
     *                 @OA\Schema(ref="#/components/schemas/Success"),
     *                 @OA\Schema(type="object",
     *                     @OA\Property(
     *                         property="data",
     *                         ref=@Model(type=CreateCredentialRecoverySecretCodeResponse::class)
     *                     )
     *                 )
     *             })
     *         )
     *     ),
     *     @OA\Response(response="400", ref="#/components/responses/BadRequest"),
     *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
     *     @OA\Response(response="422", ref="#/components/responses/UnprocessableEntity")
     * )
     *
     * @param string $credentialRecoveryId
     * @param CreateCredentialRecoverySecretCodeUseCaseInterface $useCase
     * @param CreateCredentialRecoverySecretCodeResponseNormalizerInterface $responseNormalizer
     * @return Response
     */
    public function createCredentialRecoverySecretCode(
        string $credentialRecoveryId,
        CreateCredentialRecoverySecretCodeUseCaseInterface $useCase,
        CreateCredentialRecoverySecretCodeResponseNormalizerInterface $responseNormalizer,
    ): Response {
        $request = new CreateCredentialRecoverySecretCodeRequest();
        $request->setCredentialRecoveryId($credentialRecoveryId);
        $response = $useCase->execute($request);

        return $this->respond(
            $responseNormalizer->toArray($response),
            Response::HTTP_CREATED,
        );
    }

    /**
     * @Route(
     *     path="/credential-recoveries/{credentialRecoveryId}/signing",
     *     methods={"PATCH"},
     *     requirements={
     *         "credentialRecoveryId"="%app.routing.uuid%"
     *     }
     * )
     *
     * @OA\Patch(
     *     tags={"Credential Recoveries"},
     *     summary="Sign credential recovery", security={},
     *     @OA\Parameter(name="credentialRecoveryId", in="path", required="true",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\RequestBody(required=true,
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(ref=@Model(type=SignCredentialRecoveryRequest::class, groups={"body"}))
     *         )
     *     ),
     *     @OA\Response(response="200", description="OK",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(type="object", allOf={
     *                 @OA\Schema(ref="#/components/schemas/Success"),
     *                 @OA\Schema(type="object",
     *                     @OA\Property(property="data", ref=@Model(type=SignCredentialRecoveryResponse::class))
     *                 )
     *             })
     *         )
     *     ),
     *     @OA\Response(response="400", ref="#/components/responses/BadRequest"),
     *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
     *     @OA\Response(response="422", ref="#/components/responses/UnprocessableEntity")
     * )
     *
     * @ParamConverter(name="request", class=SignCredentialRecoveryRequest::class)
     *
     * @param string $credentialRecoveryId
     * @param SignCredentialRecoveryRequest $request
     * @param SignCredentialRecoveryUseCaseInterface $useCase
     * @param SignCredentialRecoveryResponseNormalizerInterface $responseNormalizer
     * @return Response
     */
    public function signCredentialRecovery(
        string $credentialRecoveryId,
        SignCredentialRecoveryRequest $request,
        SignCredentialRecoveryUseCaseInterface $useCase,
        SignCredentialRecoveryResponseNormalizerInterface $responseNormalizer,
    ): Response {
        $request->setCredentialRecoveryId($credentialRecoveryId);
        $response = $useCase->execute($request);

        return $this->respond(
            $responseNormalizer->toArray($response),
        );
    }

    /**
     * @Route(
     *     path="/credential-recoveries/{credentialRecoveryId}/password",
     *     methods={"PATCH"},
     *     requirements={
     *         "credentialRecoveryId"="%app.routing.uuid%"
     *     }
     * )
     *
     * @OA\Patch(
     *     tags={"Credential Recoveries"},
     *     summary="Enter password for credential recovery", security={},
     *     @OA\Parameter(name="credentialRecoveryId", in="path", required="true",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\RequestBody(required=true,
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(ref=@Model(type=EnterCredentialRecoveryPasswordRequest::class, groups={"body"}))
     *         )
     *     ),
     *     @OA\Response(response="200", description="OK",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(type="object", allOf={
     *                 @OA\Schema(ref="#/components/schemas/Success"),
     *                 @OA\Schema(type="object",
     *                     @OA\Property(
     *                         property="data",
     *                         ref=@Model(type=EnterCredentialRecoveryPasswordResponse::class)
     *                     )
     *                 )
     *             })
     *         )
     *     ),
     *     @OA\Response(response="400", ref="#/components/responses/BadRequest"),
     *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
     *     @OA\Response(response="422", ref="#/components/responses/UnprocessableEntity")
     * )
     *
     * @ParamConverter(name="request", class=EnterCredentialRecoveryPasswordRequest::class)
     *
     * @param string $credentialRecoveryId
     * @param EnterCredentialRecoveryPasswordRequest $request
     * @param EnterCredentialRecoveryPasswordUseCaseInterface $useCase
     * @param EnterCredentialRecoveryPasswordResponseNormalizerInterface $responseNormalizer
     * @return Response
     */
    public function enterCredentialRecoveryPassword(
        string $credentialRecoveryId,
        EnterCredentialRecoveryPasswordRequest $request,
        EnterCredentialRecoveryPasswordUseCaseInterface $useCase,
        EnterCredentialRecoveryPasswordResponseNormalizerInterface $responseNormalizer
    ): Response {
        $request->setCredentialRecoveryId($credentialRecoveryId);
        $response = $useCase->execute($request);

        return $this->respond(
            $responseNormalizer->toArray($response),
        );
    }
}
