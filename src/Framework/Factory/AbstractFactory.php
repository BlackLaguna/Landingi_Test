<?php
declare(strict_types=1);

namespace RecruitmentApp\Framework\Factory;

use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractFactory implements DTOFactory
{
    protected EntityManagerInterface $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
