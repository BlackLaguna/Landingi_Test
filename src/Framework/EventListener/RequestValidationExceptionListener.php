<?php
declare(strict_types=1);

namespace RecruitmentApp\Framework\EventListener;

use RecruitmentApp\Framework\Exception\ApiValidationException;
use RecruitmentApp\Framework\Factory\ResponseFactory;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class RequestValidationExceptionListener
{
    private ResponseFactory $responseFactory;
    
    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }
    
    public function onKernelException(ExceptionEvent $event): void
    {
        if ($event->getThrowable() instanceof ApiValidationException) {
            $event->setResponse($this->responseFactory->createValidationResponse($event->getThrowable()->getMessage()));
        }
    }
}
