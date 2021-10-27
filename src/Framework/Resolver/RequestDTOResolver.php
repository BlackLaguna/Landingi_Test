<?php
declare(strict_types=1);

namespace RecruitmentApp\Framework\Resolver;

use RecruitmentApp\Framework\DTO\CreateArticleRequest;
use RecruitmentApp\Framework\DTO\CreateUserRequest;
use RecruitmentApp\Framework\Exception\ApiValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestDTOResolver implements ArgumentValueResolverInterface
{
    private ValidatorInterface $validator;
    
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }
    
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return match ($argument->getType()) {
            CreateArticleRequest::class, CreateUserRequest::class => true,
            default => false,
        };
    }
    
    public function resolve(Request $request, ArgumentMetadata $argument): \Generator
    {
        $dto = match ($argument->getType()) {
            CreateUserRequest::class => new CreateUserRequest($request),
            CreateArticleRequest::class => new CreateArticleRequest($request),
        };
        
        $violation = $this->validator->validate($dto);
        
        if (0 < $violation->count()) {
            throw new ApiValidationException($this->extractErrorsFromViolationList($violation));
        }
        
        yield $dto;
    }
    
    private function extractErrorsFromViolationList(ConstraintViolationListInterface $violations): string
    {
        $errors = '';
        
        /** @var ConstraintViolation $violation */
        foreach ($violations as $key => $violation) {
            $errors .= ($key + 1) . '. ' . $violation->getMessage();
        }
        
        return $errors;
    }
}
