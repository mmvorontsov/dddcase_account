<?php

namespace App\Presentation\Api\V1\Controller;

use App\Context\Account\Application\UseCase\Command\CreateContactDataChange\{
    CreateContactDataChangeResponseNormalizerInterface,
    CreateContactDataChangeUseCaseInterface,
};
use App\Context\Account\Application\UseCase\Command\CreateContactDataChange\CreateContactDataChangeRequest;
use App\Context\Account\Application\UseCase\Command\CreateContactDataChange\CreateContactDataChangeResponse;
use App\Context\Account\Application\UseCase\Command\CreateContactDataChange\Request\{
    CreateEmailChangeRequest,
    CreatePhoneChangeRequest,
};
use App\Context\Account\Application\UseCase\Command\CreateContactDataChangeSecretCode\{
    CreateContactDataChangeSecretCodeRequest,
    CreateContactDataChangeSecretCodeResponse,
    CreateContactDataChangeSecretCodeResponseNormalizerInterface,
    CreateContactDataChangeSecretCodeUseCaseInterface,
};
use App\Context\Account\Application\UseCase\Command\SignContactDataChange\{
    SignContactDataChangeRequest,
    SignContactDataChangeResponse,
    SignContactDataChangeResponseNormalizerInterface,
    SignContactDataChangeUseCaseInterface,
};
use App\Context\Account\Application\UseCase\Query\ContactDataChangeKeyMaker\{
    ContactDataChangeKeyMakerRequest,
    ContactDataChangeKeyMakerResponse,
    ContactDataChangeKeyMakerResponseNormalizerInterface,
    ContactDataChangeKeyMakerUseCaseInterface,
};
use Nelmio\ApiDocBundle\Annotation as NOA;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ContactDataChangeController
 * @package App\Presentation\Api\V1\Controller
 */
final class ContactDataChangeController extends AbstractController
{
    /**
     * @Route(
     *     path="/contact-data-changes",
     *     methods={"POST"}
     * )
     *
     * @NOA\Security(name="Bearer")
     * @OA\Post(tags={"Contact Data Changes"}, summary="Create contact data change",
     *     description="Required permissions: **PERMISSION__DDDCASE_ACCOUNT__CONTACT_DATA_CHANGE_CREATE**",
     *     @OA\RequestBody(required=true,
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(
     *                 example={"type": "EMAIL", "toEmail": "email@example.com"},
     *                 oneOf={
     *                     @OA\Schema(ref=@Model(type=CreateEmailChangeRequest::class, groups={"body"})),
     *                     @OA\Schema(ref=@Model(type=CreatePhoneChangeRequest::class, groups={"body"})),
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(response="201", description="Created",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(type="object", allOf={
     *                 @OA\Schema(ref="#/components/schemas/Success"),
     *                 @OA\Schema(type="object",
     *                     @OA\Property(property="data", ref=@Model(type=CreateContactDataChangeResponse::class))
     *                 )
     *             })
     *         )
     *     ),
     *     @OA\Response(response="400", ref="#/components/responses/BadRequest"),
     *     @OA\Response(response="403", ref="#/components/responses/Forbidden"),
     *     @OA\Response(response="422", ref="#/components/responses/UnprocessableEntity")
     * )
     *
     * @ParamConverter(name="request", class=CreateContactDataChangeRequest::class)
     *
     * @param CreateContactDataChangeRequest $request
     * @param CreateContactDataChangeUseCaseInterface $useCase
     * @param CreateContactDataChangeResponseNormalizerInterface $responseNormalizer
     * @return Response
     */
    public function createContactDataChange(
        CreateContactDataChangeRequest $request,
        CreateContactDataChangeUseCaseInterface $useCase,
        CreateContactDataChangeResponseNormalizerInterface $responseNormalizer
    ): Response {
        $response = $useCase->execute($request);

        return $this->respond(
            $responseNormalizer->toArray($response),
            Response::HTTP_CREATED
        );
    }

    /**
     * @Route(
     *     path="/contact-data-changes/{contactDataChangeId}/key-maker",
     *     methods={"GET"},
     *     requirements={
     *         "contactDataChangeId"="%app.routing.uuid%"
     *     }
     * )
     *
     * @NOA\Security(name="Bearer")
     * @OA\Get(tags={"Contact Data Changes"}, summary="Read contact data change key maker",
     *     description="Required permissions: **PERMISSION__DDDCASE_ACCOUNT__CONTACT_DATA_CHANGE_KEY_MAKER_READ**",
     *     @OA\Parameter(name="contactDataChangeId", in="path", required="true",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(response="200", description="OK",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(type="object", allOf={
     *                 @OA\Schema(ref="#/components/schemas/Success"),
     *                 @OA\Schema(type="object",
     *                     @OA\Property(property="data", ref=@Model(type=ContactDataChangeKeyMakerResponse::class))
     *                 )
     *             })
     *         )
     *     ),
     *     @OA\Response(response="403", ref="#/components/responses/Forbidden"),
     *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
     *     @OA\Response(response="422", ref="#/components/responses/UnprocessableEntity")
     * )
     *
     * @param string $contactDataChangeId
     * @param ContactDataChangeKeyMakerUseCaseInterface $useCase
     * @param ContactDataChangeKeyMakerResponseNormalizerInterface $responseNormalizer
     * @return Response
     */
    public function readContactDataChangeKeyMaker(
        string $contactDataChangeId,
        ContactDataChangeKeyMakerUseCaseInterface $useCase,
        ContactDataChangeKeyMakerResponseNormalizerInterface $responseNormalizer
    ): Response {
        $request = new ContactDataChangeKeyMakerRequest();
        $request->setContactDataChangeId($contactDataChangeId);
        $response = $useCase->execute($request);

        return $this->respond(
            $responseNormalizer->toArray($response)
        );
    }

    /**
     * @Route(
     *     path="/contact-data-changes/{contactDataChangeId}/key-maker/secret-codes",
     *     methods={"POST"},
     *     requirements={
     *         "contactDataChangeId"="%app.routing.uuid%"
     *     }
     * )
     *
     * @OA\Post(tags={"Contact Data Changes"}, summary="Create secret code of contact data change key maker",
     *     description="Required permissions: **PERMISSION__DDDCASE_ACCOUNT__CONTACT_DATA_CHANGE_SECRET_CODE_CREATE**",
     *     @OA\Parameter(name="contactDataChangeId", in="path", required="true",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(response="201", description="Created",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(type="object", allOf={
     *                 @OA\Schema(ref="#/components/schemas/Success"),
     *                 @OA\Schema(type="object",
     *                     @OA\Property(
     *                         property="data",
     *                         ref=@Model(type=CreateContactDataChangeSecretCodeResponse::class)
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
     * @param string $contactDataChangeId
     * @param CreateContactDataChangeSecretCodeUseCaseInterface $useCase
     * @param CreateContactDataChangeSecretCodeResponseNormalizerInterface $responseNormalizer
     * @return Response
     */
    public function createContactDataChangeSecretCode(
        string $contactDataChangeId,
        CreateContactDataChangeSecretCodeUseCaseInterface $useCase,
        CreateContactDataChangeSecretCodeResponseNormalizerInterface $responseNormalizer
    ): Response {
        $request = new CreateContactDataChangeSecretCodeRequest();
        $request->setContactDataChangeId($contactDataChangeId);
        $response = $useCase->execute($request);

        return $this->respond(
            $responseNormalizer->toArray($response),
            Response::HTTP_CREATED
        );
    }

    /**
     * @Route(
     *     path="/contact-data-changes/{contactDataChangeId}/signing",
     *     methods={"PATCH"},
     *     requirements={
     *         "contactDataChangeId"="%app.routing.uuid%"
     *     }
     * )
     *
     * @OA\Patch(tags={"Contact Data Changes"}, summary="Sign contact data change (update contact data)",
     *     description="Required permissions: **PERMISSION__DDDCASE_ACCOUNT__CONTACT_DATA_CHANGE_SIGN**",
     *     @OA\Parameter(name="contactDataChangeId", in="path", required="true",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\RequestBody(required=true,
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(ref=@Model(type=SignContactDataChangeRequest::class, groups={"body"}))
     *         )
     *     ),
     *     @OA\Response(response="200", description="OK",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(type="object", allOf={
     *                 @OA\Schema(ref="#/components/schemas/Success"),
     *                 @OA\Schema(type="object",
     *                     @OA\Property(
     *                         property="data",
     *                         ref=@Model(type=SignContactDataChangeResponse::class)
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
     * @ParamConverter(name="request", class=SignContactDataChangeRequest::class)
     *
     * @param string $contactDataChangeId
     * @param SignContactDataChangeRequest $request
     * @param SignContactDataChangeUseCaseInterface $useCase
     * @param SignContactDataChangeResponseNormalizerInterface $responseNormalizer
     * @return Response
     */
    public function signContactDataChange(
        string $contactDataChangeId,
        SignContactDataChangeRequest $request,
        SignContactDataChangeUseCaseInterface $useCase,
        SignContactDataChangeResponseNormalizerInterface $responseNormalizer
    ): Response {
        $request->setContactDataChangeId($contactDataChangeId);
        $response = $useCase->execute($request);

        return $this->respond(
            $responseNormalizer->toArray($response)
        );
    }
}
