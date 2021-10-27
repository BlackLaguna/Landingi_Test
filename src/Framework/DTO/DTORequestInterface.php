<?php
declare(strict_types=1);

namespace RecruitmentApp\Framework\DTO;

use Symfony\Component\HttpFoundation\Request;

interface DTORequestInterface
{
    public function __construct(Request $request);
}
