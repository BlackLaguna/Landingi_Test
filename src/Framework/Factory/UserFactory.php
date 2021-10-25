<?php
declare(strict_types=1);

namespace RecruitmentApp\Framework\Factory;

use Doctrine\ORM\EntityManagerInterface;
use RecruitmentApp\Domain\Email;
use RecruitmentApp\Domain\User;
use RecruitmentApp\Framework\DTO\CreateUserRequest;
use RecruitmentApp\Domain\User\ApiKey;

class UserFactory
{
    private EntityManagerInterface $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function createFromRequest(CreateUserRequest $request): User
    {
        $user = new User(new Email($request->getEmail()), ApiKey::generate());
        $this->persistAndFlush($user);
        
        return $user;
    }
    
    private function persistAndFlush(User $user)
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
