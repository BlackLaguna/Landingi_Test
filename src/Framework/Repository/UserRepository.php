<?php
declare(strict_types=1);

namespace RecruitmentApp\Framework\Repository;

use Doctrine\Persistence\ManagerRegistry;
use RecruitmentApp\Domain\User;

class UserRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }
}
