<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Api\Controller;

use App\Shared\Infrastructure\Api\Controller\Action;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/test', methods: ['GET'])]
class TestController extends Action
{
    public function __invoke(): JsonResponse
    {
        $requestingUser = $this->getRequestingUser();

        return new JsonResponse([
            'id' => $requestingUser->ssoId->value,
            'email' => $requestingUser->email->value()
        ]);
    }
}
