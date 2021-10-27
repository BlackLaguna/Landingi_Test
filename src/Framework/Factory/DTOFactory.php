<?php
declare(strict_types=1);

namespace RecruitmentApp\Framework\Factory;

use RecruitmentApp\Domain\AbstractEntity;
use RecruitmentApp\Framework\DTO\DTORequestInterface;

interface DTOFactory
{
    public function createFromDTO(DTORequestInterface $DTO): AbstractEntity;
}
