<?php

namespace App\Presentation\Api\V1\Controller;

use App\Context\Account\Application\UseCase\Command\UpdateUserRoles\UpdateUserRolesRequest;
use App\Context\Account\Application\UseCase\Command\UpdateUserRoles\UpdateUserRolesResponse;
use App\Context\Account\Application\UseCase\Command\UpdateUserRoles\UpdateUserRolesResponseNormalizerInterface;
use App\Context\Account\Application\UseCase\Command\UpdateUserRoles\UpdateUserRolesUseCaseInterface;
use App\Context\Account\Application\UseCase\Command\UpdateUser\{
    UpdateUserRequest,
    UpdateUserResponse,
    UpdateUserResponseNormalizerInterface,
    UpdateUserUseCaseInterface,
};
use App\Context\Account\Application\UseCase\Command\UpdateUserCredentialPassword\{
    UpdateUserCredentialPasswordRequest,
    UpdateUserCredentialPasswordResponse,
    UpdateUserCredentialPasswordResponseNormalizerInterface,
    UpdateUserCredentialPasswordUseCaseInterface,
};
use App\Context\Account\Application\UseCase\Query\User\{
    UserRequest,
    UserResponse,
    UserResponseNormalizerInterface,
    UserUseCaseInterface,
};
use App\Context\Account\Application\UseCase\Query\UserByCredential\{
    UserByCredentialRequest,
    UserByCredentialResponse,
    UserByCredentialResponseNormalizerInterface,
    UserByCredentialUseCaseInterface,
};
use App\Context\Account\Application\UseCase\Query\UserContactData\{
    UserContactDataRequest,
    UserContactDataResponse,
};
use App\Context\Account\Application\UseCase\Query\UserContactData\{
    UserContactDataResponseNormalizerInterface,
    UserContactDataUseCaseInterface,
};
use App\Context\Account\Application\UseCase\Query\UserCredential\{
    UserCredentialRequest,
    UserCredentialResponse,
    UserCredentialResponseNormalizerInterface,
    UserCredentialUseCaseInterface,
};
use App\Context\Account\Application\UseCase\Query\UserPermissions\{
    UserPermissionsRequest,
    UserPermissionsResponse,
    UserPermissionsResponseNormalizerInterface,
    UserPermissionsUseCaseInterface,
};
use App\Context\Account\Application\UseCase\Query\Users\{
    UsersRequest,
    UsersResponse,
    UsersResponseNormalizerInterface,
    UsersUseCaseInterface,
};
use Nelmio\ApiDocBundle\Annotation as NOA;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Presentation\Api\V1\Controller
 */
final class UserController extends AbstractController
{
    /**
     * @Route(
     *     path="/users",
     *     methods={"GET"}
     * )
     *
     * @NOA\Security(name="Bearer")
     * @OA\Get(tags={"Users"}, summary="Read users",
     *     description="Required permissions: **PERMISSION__DDDCASE_ACCOUNT__USERS_READ**",
     *     @OA\Parameter(name="jsonQuery", in="query",
     *         @OA\Schema(ref=@Model(type=UsersRequest::class, groups={"query"}))
     *     ),
     *     @OA\Response(response="200", description="OK",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(type="object", allOf={
     *                 @OA\Schema(ref="#/components/schemas/Success"),
     *                 @OA\Schema(type="object",
     *                     @OA\Property(property="data", ref=@Model(type=UsersResponse::class))
     *                 )
     *             })
     *         )
     *     ),
     *     @OA\Response(response="403", ref="#/components/responses/Forbidden"),
     *     @OA\Response(response="422", ref="#/components/responses/UnprocessableEntity")
     * )
     *
     * @ParamConverter(name="request", class=UsersRequest::class)
     *
     * @param UsersRequest $request
     * @param UsersUseCaseInterface $useCase
     * @param UsersResponseNormalizerInterface $responseNormalizer
     * @return Response
     */
    public function readUsers(
        UsersRequest $request,
        UsersUseCaseInterface $useCase,
        UsersResponseNormalizerInterface $responseNormalizer
    ): Response {
        $response = $useCase->execute($request);

        return $this->respond(
            $responseNormalizer->toArray($response)
        );
    }

    /**
     * @Route(
     *     path="/users/{userId}",
     *     methods={"GET"},
     *     requirements={
     *         "userId"="%app.routing.uuid%"
     *     }
     * )
     *
     * @NOA\Security(name="Bearer")
     * @OA\Get(tags={"Users"}, summary="Read user",
     *     description="Required permissions: **PERMISSION__DDDCASE_ACCOUNT__USER_READ**",
     *     @OA\Parameter(name="userId", in="path", required="true",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(response="200", description="OK",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(type="object", allOf={
     *                 @OA\Schema(ref="#/components/schemas/Success"),
     *                 @OA\Schema(type="object",
     *                     @OA\Property(property="data", ref=@Model(type=UserResponse::class))
     *                 )
     *             })
     *         )
     *     ),
     *     @OA\Response(response="403", ref="#/components/responses/Forbidden"),
     *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
     *     @OA\Response(response="422", ref="#/components/responses/UnprocessableEntity")
     * )
     *
     * @param string $userId
     * @param UserUseCaseInterface $useCase
     * @param UserResponseNormalizerInterface $responseNormalizer
     * @return Response
     */
    public function readUser(
        string $userId,
        UserUseCaseInterface $useCase,
        UserResponseNormalizerInterface $responseNormalizer
    ): Response {
        $request = new UserRequest();
        $request->setUserId($userId);
        $response = $useCase->execute($request);

        return $this->respond(
            $responseNormalizer->toArray($response)
        );
    }

    /**
     * @Route(
     *     path="/get-one/by-credential/users",
     *     methods={"POST"}
     * )
     *
     * @NOA\Security(name="Bearer")
     * @OA\Post(tags={"Users"}, summary="Read user by credential",
     *     description="Required permissions: **PERMISSION__DDDCASE_ACCOUNT__USER_READ_BY_CREDENTIAL**",
     *     @OA\RequestBody(required=false,
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(ref=@Model(type=UserByCredentialRequest::class, groups={"body"}))
     *         )
     *     ),
     *     @OA\Response(response="200", description="OK",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(type="object", allOf={
     *                 @OA\Schema(ref="#/components/schemas/Success"),
     *                 @OA\Schema(type="object",
     *                     @OA\Property(property="data", ref=@Model(type=UserByCredentialResponse::class))
     *                 )
     *             })
     *         )
     *     ),
     *     @OA\Response(response="403", ref="#/components/responses/Forbidden"),
     *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
     *     @OA\Response(response="422", ref="#/components/responses/UnprocessableEntity")
     * )
     *
     * @ParamConverter(name="request", class=UserByCredentialRequest::class)
     *
     * @param UserByCredentialRequest $request
     * @param UserByCredentialUseCaseInterface $useCase
     * @param UserByCredentialResponseNormalizerInterface $responseNormalizer
     * @return Response
     */
    public function readUserByCredential(
        UserByCredentialRequest $request,
        UserByCredentialUseCaseInterface $useCase,
        UserByCredentialResponseNormalizerInterface $responseNormalizer
    ): Response {
        $response = $useCase->execute($request);

        return $this->respond(
            $responseNormalizer->toArray($response)
        );
    }

    /**
     * @Route(
     *     path="/users/{userId}",
     *     methods={"PATCH"},
     *     requirements={
     *         "userId"="%app.routing.uuid%"
     *     }
     * )
     *
     * @NOA\Security(name="Bearer")
     * @OA\Patch(tags={"Users"}, summary="Update user",
     *     description="Required permissions: **PERMISSION__DDDCASE_ACCOUNT__USER_UPDATE**",
     *     @OA\Parameter(name="userId", in="path", required="true",
     *         @OA\Schema(format="uuid")
     *     ),
     *     @OA\RequestBody(required=true,
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(ref=@Model(type=UpdateUserRequest::class, groups={"body"}))
     *         )
     *     ),
     *     @OA\Response(response="200", description="OK",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(type="object", allOf={
     *                 @OA\Schema(ref="#/components/schemas/Success"),
     *                 @OA\Schema(type="object",
     *                     @OA\Property(property="data", ref=@Model(type=UpdateUserResponse::class))
     *                 )
     *             })
     *         )
     *     ),
     *     @OA\Response(response="400", ref="#/components/responses/BadRequest"),
     *     @OA\Response(response="403", ref="#/components/responses/Forbidden"),
     *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
     *     @OA\Response(response="422", ref="#/components/responses/UnprocessableEntity")
     * )
     *
     * @ParamConverter(name="request", class=UpdateUserRequest::class)
     *
     * @param string $userId
     * @param UpdateUserRequest $request
     * @param UpdateUserUseCaseInterface $useCase
     * @param UpdateUserResponseNormalizerInterface $responseNormalizer
     * @return Response
     */
    public function updateUser(
        string $userId,
        UpdateUserRequest $request,
        UpdateUserUseCaseInterface $useCase,
        UpdateUserResponseNormalizerInterface $responseNormalizer
    ): Response {
        $request->setUserId($userId);
        $response = $useCase->execute($request);

        return $this->respond(
            $responseNormalizer->toArray($response)
        );
    }

    /**
     * @Route(
     *     path="/users/{userId}/roles",
     *     methods={"PATCH"},
     *     requirements={
     *         "userId"="%app.routing.uuid%"
     *     }
     * )
     *
     * @NOA\Security(name="Bearer")
     * @OA\Patch(tags={"Users"}, summary="Update user roles",
     *     description="Required permissions: **PERMISSION__DDDCASE_ACCOUNT__USER_ROLES_UPDATE**",
     *     @OA\Parameter(name="userId", in="path", required="true",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\RequestBody(required=true,
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(ref=@Model(type=UpdateUserRolesRequest::class, groups={"body"}))
     *         )
     *     ),
     *     @OA\Response(response="200", description="OK",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(type="object", allOf={
     *                 @OA\Schema(ref="#/components/schemas/Success"),
     *                 @OA\Schema(type="object",
     *                     @OA\Property(property="data", ref=@Model(type=UpdateUserRolesResponse::class))
     *                 )
     *             })
     *         )
     *     ),
     *     @OA\Response(response="400", ref="#/components/responses/BadRequest"),
     *     @OA\Response(response="403", ref="#/components/responses/Forbidden"),
     *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
     *     @OA\Response(response="422", ref="#/components/responses/UnprocessableEntity")
     * )
     *
     * @ParamConverter(name="request", class=UpdateUserRolesRequest::class)
     *
     * @param string $userId
     * @param UpdateUserRolesRequest $request
     * @param UpdateUserRolesUseCaseInterface $useCase
     * @param UpdateUserRolesResponseNormalizerInterface $responseNormalizer
     * @return Response
     */
    public function updateUserRoles(
        string $userId,
        UpdateUserRolesRequest $request,
        UpdateUserRolesUseCaseInterface $useCase,
        UpdateUserRolesResponseNormalizerInterface $responseNormalizer
    ): Response {
        $request->setUserId($userId);
        $response = $useCase->execute($request);

        return $this->respond(
            $responseNormalizer->toArray($response)
        );
    }

    /**
     * @Route(
     *     path="/users/{userId}/permissions",
     *     methods={"GET"},
     *     requirements={
     *         "userId"="%app.routing.uuid%"
     *     }
     * )
     *
     * @NOA\Security(name="Bearer")
     * @OA\Get(tags={"Users"}, summary="Read user permissions",
     *     description="Required permissions: **PERMISSION__DDDCASE_ACCOUNT__USER_PERMISSIONS_READ**",
     *     @OA\Parameter(name="userId", in="path", required="true",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(response="200", description="OK",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(type="object", allOf={
     *                 @OA\Schema(ref="#/components/schemas/Success"),
     *                 @OA\Schema(type="object",
     *                     @OA\Property(property="data", ref=@Model(type=UserPermissionsResponse::class))
     *                 )
     *             })
     *         )
     *     ),
     *     @OA\Response(response="400", ref="#/components/responses/BadRequest"),
     *     @OA\Response(response="403", ref="#/components/responses/Forbidden"),
     *     @OA\Response(response="404", ref="#/components/responses/NotFound")
     * )
     *
     * @param string $userId
     * @param UserPermissionsUseCaseInterface $useCase
     * @param UserPermissionsResponseNormalizerInterface $responseNormalizer
     * @return Response
     */
    public function readUserPermissions(
        string $userId,
        UserPermissionsUseCaseInterface $useCase,
        UserPermissionsResponseNormalizerInterface $responseNormalizer
    ): Response {
        $request = new UserPermissionsRequest();
        $request->setUserId($userId);
        $response = $useCase->execute($request);

        return $this->respond(
            $responseNormalizer->toArray($response)
        );
    }

    /**
     * @Route(
     *     path="/users/{userId}/credential",
     *     methods={"GET"},
     *     requirements={
     *         "userId"="%app.routing.uuid%"
     *     }
     * )
     *
     * @NOA\Security(name="Bearer")
     * @OA\Get(tags={"Users"}, summary="Read user credential",
     *     description="Required permissions: **PERMISSION__DDDCASE_ACCOUNT__USER_CREDENTIAL_READ**",
     *     @OA\Parameter(name="userId", in="path", required="true",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(response="200", description="OK",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(type="object", allOf={
     *                 @OA\Schema(ref="#/components/schemas/Success"),
     *                 @OA\Schema(type="object",
     *                     @OA\Property(property="data", ref=@Model(type=UserCredentialResponse::class))
     *                 )
     *             })
     *         )
     *     ),
     *     @OA\Response(response="403", ref="#/components/responses/Forbidden"),
     *     @OA\Response(response="404", ref="#/components/responses/NotFound")
     * )
     *
     * @param string $userId
     * @param UserCredentialUseCaseInterface $useCase
     * @param UserCredentialResponseNormalizerInterface $responseNormalizer
     * @return Response
     */
    public function readUserCredential(
        string $userId,
        UserCredentialUseCaseInterface $useCase,
        UserCredentialResponseNormalizerInterface $responseNormalizer
    ): Response {
        $request = new UserCredentialRequest();
        $request->setUserId($userId);
        $response = $useCase->execute($request);

        return $this->respond(
            $responseNormalizer->toArray($response)
        );
    }

    /**
     * @Route(
     *     path="/users/{userId}/credential/password",
     *     methods={"PATCH"},
     *     requirements={
     *         "userId"="%app.routing.uuid%"
     *     }
     * )
     *
     * @NOA\Security(name="Bearer")
     * @OA\Patch(tags={"Users"}, summary="Update user password",
     *     description="Required permissions: **PERMISSION__DDDCASE_ACCOUNT__USER_CREDENTIAL_PASSWORD_UPDATE**",
     *     @OA\Parameter(name="userId", in="path", required="true",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\RequestBody(required=true,
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(ref=@Model(type=UpdateUserCredentialPasswordRequest::class, groups={"body"}))
     *         )
     *     ),
     *     @OA\Response(response="200", description="OK",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(type="object", allOf={
     *                 @OA\Schema(ref="#/components/schemas/Success"),
     *                 @OA\Schema(type="object",
     *                     @OA\Property(property="data", ref=@Model(type=UpdateUserCredentialPasswordResponse::class))
     *                 )
     *             })
     *         )
     *     ),
     *     @OA\Response(response="400", ref="#/components/responses/BadRequest"),
     *     @OA\Response(response="403", ref="#/components/responses/Forbidden"),
     *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
     *     @OA\Response(response="422", ref="#/components/responses/UnprocessableEntity")
     * )
     *
     * @ParamConverter(name="request", class=UpdateUserCredentialPasswordRequest::class)
     *
     * @param string $userId
     * @param UpdateUserCredentialPasswordRequest $request
     * @param UpdateUserCredentialPasswordUseCaseInterface $useCase
     * @param UpdateUserCredentialPasswordResponseNormalizerInterface $responseNormalizer
     * @return Response
     */
    public function updateUserCredentialPassword(
        string $userId,
        UpdateUserCredentialPasswordRequest $request,
        UpdateUserCredentialPasswordUseCaseInterface $useCase,
        UpdateUserCredentialPasswordResponseNormalizerInterface $responseNormalizer
    ): Response {
        $request->setUserId($userId);
        $response = $useCase->execute($request);

        return $this->respond(
            $responseNormalizer->toArray($response)
        );
    }

    /**
     * @Route(
     *     path="/users/{userId}/contact-data",
     *     methods={"GET"},
     *     requirements={
     *         "userId"="%app.routing.uuid%"
     *     }
     * )
     *
     * @NOA\Security(name="Bearer")
     * @OA\Get(tags={"Users"}, summary="Read user contact data",
     *     description="Required permissions: **PERMISSION__DDDCASE_ACCOUNT__USER_CONTACT_DATA_READ**",
     *     @OA\Parameter(name="userId", in="path", required="true",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(response="200", description="OK",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(type="object", allOf={
     *                 @OA\Schema(ref="#/components/schemas/Success"),
     *                 @OA\Schema(type="object",
     *                     @OA\Property(property="data", ref=@Model(type=UserContactDataResponse::class))
     *                 )
     *             })
     *         )
     *     ),
     *     @OA\Response(response="403", ref="#/components/responses/Forbidden"),
     *     @OA\Response(response="404", ref="#/components/responses/NotFound")
     * )
     *
     * @param string $userId
     * @param UserContactDataUseCaseInterface $useCase
     * @param UserContactDataResponseNormalizerInterface $responseNormalizer
     * @return Response
     */
    public function readUserContactData(
        string $userId,
        UserContactDataUseCaseInterface $useCase,
        UserContactDataResponseNormalizerInterface $responseNormalizer
    ): Response {
        $request = new UserContactDataRequest();
        $request->setUserId($userId);
        $response = $useCase->execute($request);

        return $this->respond(
            $responseNormalizer->toArray($response)
        );
    }
}
