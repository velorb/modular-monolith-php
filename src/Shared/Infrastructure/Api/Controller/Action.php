<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Api\Controller;

use App\Shared\Application\RequestingUserDto;
use App\Shared\Infrastructure\Api\Security\SecurityUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class Action extends AbstractController
{
    public function getRequestingUser(): RequestingUserDto
    {
        /** @var SecurityUser $user */
        $user = $this->getUser();

        return $user->getRequestingUserDto();
    }
}
