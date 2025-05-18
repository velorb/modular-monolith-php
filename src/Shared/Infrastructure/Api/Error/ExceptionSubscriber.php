<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Api\Error;

use App\Shared\Application\Exception\ApplicationException;
use App\Shared\Application\Exception\NotFoundException;
use App\Shared\Application\Exception\PermissionDeniedException;
use App\Shared\Domain\Exception\DomainException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            ExceptionEvent::class => ['onKernelException', 255],
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $this->findException($event->getThrowable());
        if ($exception === null) {
            return;
        }

        $statusCode = Response::HTTP_BAD_REQUEST;
        if ($exception instanceof ApplicationException) {
            $statusCode = $this->getStatusCodeFromApplicationException($exception);
        }
        $httpException = HttpException::fromStatusCode($statusCode, $exception->getMessage(), $exception);
        $event->setThrowable($httpException);
    }

    /**
     * @return ApplicationException|DomainException|null
     */
    private function findException(\Throwable $exception): ?object
    {
        if ($exception instanceof ApplicationException || $exception instanceof DomainException) {
            return $exception;
        }

        if ($exception instanceof HandlerFailedException) {
            $appExceptions = $exception->getWrappedExceptions(ApplicationException::class, true);
            if (!empty($appExceptions)) {
                return array_values($appExceptions)[0];
            }

            $domainExceptions = $exception->getWrappedExceptions(DomainException::class, true);
            if (!empty($domainExceptions)) {
                return array_values($domainExceptions)[0];
            }
        }

        return null;
    }

    private function getStatusCodeFromApplicationException(ApplicationException $exception): int
    {
        return match (get_class($exception)) {
            NotFoundException::class => Response::HTTP_NOT_FOUND,
            PermissionDeniedException::class => Response::HTTP_FORBIDDEN,
            default => Response::HTTP_BAD_REQUEST,
        };
    }
}
