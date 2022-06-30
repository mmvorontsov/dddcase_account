<?php

namespace App\Presentation\Api\V1\Controller;

use App\Context\Account\Application\UseCase\Query\Role\RoleRequest;
use App\Context\Account\Application\UseCase\Query\Role\RoleResponse;
use App\Context\Account\Application\UseCase\Query\Role\RoleResponseNormalizerInterface;
use App\Context\Account\Application\UseCase\Query\Role\RoleUseCaseInterface;
use App\Context\Account\Application\UseCase\Query\Roles\RolesRequest;
use App\Context\Account\Application\UseCase\Query\Roles\RolesResponse;
use App\Context\Account\Application\UseCase\Query\Roles\RolesResponseNormalizerInterface;
use App\Context\Account\Application\UseCase\Query\Roles\RolesUseCaseInterface;
use Nelmio\ApiDocBundle\Annotation as NOA;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RoleController
 * @package App\Presentation\Api\V1\Controller
 */
final class RoleController extends AbstractController
{
    /**
     * @Route(
     *     path="/roles",
     *     methods={"GET"}
     * )
     *
     * @NOA\Security(name="Bearer")
     * @OA\Get(tags={"Roles"}, summary="Read roles",
     *     description="Required permissions: **PERMISSION__DDDCASE_ACCOUNT__ROLES_READ**",
     *     @OA\Parameter(name="jsonQuery", in="query",
     *         @OA\Schema(ref=@Model(type=RolesRequest::class, groups={"query"}))
     *     ),
     *     @OA\Response(response="200", description="OK",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(type="object", allOf={
     *                 @OA\Schema(ref="#/components/schemas/Success"),
     *                 @OA\Schema(type="object",
     *                     @OA\Property(property="data", ref=@Model(type=RolesResponse::class))
     *                 )
     *             })
     *         )
     *     ),
     *     @OA\Response(response="403", ref="#/components/responses/Forbidden"),
     *     @OA\Response(response="422", ref="#/components/responses/UnprocessableEntity")
     * )
     *
     * @ParamConverter(name="request", class=RolesRequest::class)
     *
     * @param RolesRequest $request
     * @param RolesUseCaseInterface $useCase
     * @param RolesResponseNormalizerInterface $responseNormalizer
     * @return Response
     */
    public function readRoles(
        RolesRequest $request,
        RolesUseCaseInterface $useCase,
        RolesResponseNormalizerInterface $responseNormalizer
    ): Response {
        $response = $useCase->execute($request);

        return $this->respond(
            $responseNormalizer->toArray($response)
        );
    }

    /**
     * @Route(
     *     path="/roles/{roleId}",
     *     methods={"GET"},
     *     requirements={
     *         "userId"="^[\w]+$"
     *     }
     * )
     *
     * @NOA\Security(name="Bearer")
     * @OA\Get(tags={"Roles"}, summary="Read role",
     *     description="Required permissions: **PERMISSION__DDDCASE_ACCOUNT__ROLE_READ**",
     *     @OA\Parameter(name="roleId", in="path", required="true", example="ROLE_PROTECTED__USER__BASE",
     *         description="The role ID must have the ROLE_ prefix",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="OK",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(type="object", allOf={
     *                 @OA\Schema(ref="#/components/schemas/Success"),
     *                 @OA\Schema(type="object",
     *                     @OA\Property(property="data", ref=@Model(type=RoleResponse::class))
     *                 )
     *             })
     *         )
     *     ),
     *     @OA\Response(response="403", ref="#/components/responses/Forbidden"),
     *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
     *     @OA\Response(response="422", ref="#/components/responses/UnprocessableEntity")
     * )
     *
     * @param string $roleId
     * @param RoleUseCaseInterface $useCase
     * @param RoleResponseNormalizerInterface $responseNormalizer
     * @return Response
     */
    public function readRole(
        string $roleId,
        RoleUseCaseInterface $useCase,
        RoleResponseNormalizerInterface $responseNormalizer
    ): Response {
        $request = new RoleRequest();
        $request->setRoleId($roleId);
        $response = $useCase->execute($request);

        return $this->respond(
            $responseNormalizer->toArray($response)
        );
    }
}
