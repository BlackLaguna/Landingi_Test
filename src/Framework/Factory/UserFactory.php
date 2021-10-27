<?php
declare(strict_types=1);

namespace RecruitmentApp\Framework\Factory;

use RecruitmentApp\Domain\Email;
use RecruitmentApp\Domain\User;
use RecruitmentApp\Framework\DTO\CreateUserRequest;
use RecruitmentApp\Domain\User\ApiKey;
use RecruitmentApp\Framework\DTO\DTORequestInterface;

class UserFactory extends AbstractFactory
{
    /**
     * @param CreateUserRequest $DTO
     * @return User
     */
    public function createFromDTO(DTORequestInterface $DTO): User
    {
        $user = new User(new Email($DTO->getEmail()), ApiKey::generate());
        
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        
        return $user;
    }
}
