<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Api\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/docs', name: 'swagger_docs')]
class OpenApiController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('swagger.html.twig');
    }
}
