<?php

namespace App\System\Controller\Development\Generation;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use App\Context\Account\Infrastructure\Security\Client\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CredentialsGenerationController
 * @package App\System\Controller\Development\Generation
 */
final class CredentialsGenerationController extends AbstractController
{
    /**
     * @Route(
     *     path="/credentials-generation/jwt",
     *     methods={"POST"}
     * )
     *
     * @param Request $request
     * @param JWTTokenManagerInterface $jwtTokenManager
     * @return Response
     */
    public function confirmUserRegistrationEmail(Request $request, JWTTokenManagerInterface $jwtTokenManager): Response
    {
        $payload = [
            'id' => $request->get('id'),
            'name' => $request->get('name'),
            'roles' => $request->get('roles'),
            'type' => $request->get('type'),
        ];

        $client = Client::createFromPayload($payload['id'], $payload);

        return $this->json(['jwt' => $jwtTokenManager->createFromPayload($client, $payload)]);
    }
}
