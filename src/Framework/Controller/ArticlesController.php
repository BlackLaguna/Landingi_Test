<?php
declare(strict_types=1);

namespace RecruitmentApp\Framework\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/articles')]
class ArticlesController
{
    #[Route(name: 'index', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
    
    }
    
    #[Route(name: 'index', methods: ['GET'])]
    public function getList(Request $request): JsonResponse
    {
    
    }
}
