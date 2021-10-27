<?php
declare(strict_types=1);

namespace RecruitmentApp\Framework\Factory;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseFactory
{
    public function createValidationResponse(string $errors): JsonResponse
    {
        return new JsonResponse(['error' => $errors], Response::HTTP_BAD_REQUEST);
    }
    
    public function createNoAuthResponse(): JsonResponse
    {
        return new JsonResponse(['No user found'], Response::HTTP_UNAUTHORIZED);
    }
}
