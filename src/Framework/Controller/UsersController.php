<?php
declare(strict_types=1);

namespace RecruitmentApp\Framework\Controller;

use RecruitmentApp\Framework\DTO\CreateUserRequest;
use RecruitmentApp\Framework\Message\UserMessage;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

class UsersController
{
    
    #[Route(path: '/users', name: 'index', methods: ['POST'])]
    public function create(CreateUserRequest $request): JsonResponse
    {
        $envelope = $this->bus->dispatch(new UserMessage($request));
        $user = $envelope->last(HandledStamp::class);
        
        return new JsonResponse($user, Response::HTTP_CREATED);
    }
}
