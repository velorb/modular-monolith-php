<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Api\Controller\User\Me;

use App\Shared\Application\Bus\Query\IQueryBus;
use App\Shared\Infrastructure\Api\Controller\Action;
use App\User\Core\Query\Internal\User\Me\GetMeQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/user/me', name: 'user.user.me', methods: ['GET'])]
class GetMetAction extends Action
{
    public function __construct(
        private readonly IQueryBus $queryBus,
    ) {
    }

    public function __invoke(): JsonResponse
    {
        return $this->json(
            $this->queryBus->ask(
                new GetMeQuery($this->getRequestingUser()->ssoId)
            )
        );
    }
}
