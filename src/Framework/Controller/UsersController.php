<?php
declare(strict_types=1);

namespace RecruitmentApp\Framework\Controller;

use Doctrine\ORM\EntityManagerInterface;
use RecruitmentApp\Framework\DTO\CreateUserRequest;
use RecruitmentApp\Framework\Message\UserMessage;
use RecruitmentApp\Framework\Pagination\Factory\ORMPagerFantaFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/users')]
class UsersController extends ApiController
{
    private MessageBusInterface $messageBus;
    private EntityManagerInterface $entityManager;
    
    public function __construct(
        ORMPagerFantaFactory $pagerFantaFactory,
        MessageBusInterface $messageBus,
        EntityManagerInterface $entityManager
    ) {
        parent::__construct($pagerFantaFactory);
        $this->messageBus = $messageBus;
        $this->entityManager = $entityManager;
    }
    
    #[Route(name: 'index', methods: ['POST'])]
    public function create(CreateUserRequest $request): JsonResponse
    {
        $envelope = $this->messageBus->dispatch(new UserMessage($request));
        $user = $envelope->last(HandledStamp::class)->getResult();
        
        return new JsonResponse($user, Response::HTTP_CREATED);
    }
    
    #[Route(name: 'delete_user', methods: ['DELETE'])]
    public function delete(Request $request): JsonResponse
    {
        $this->entityManager->remove($this->getUser());
        $this->entityManager->flush();
        
        return new JsonResponse(['deleted' => true], Response::HTTP_OK);
    }
}
