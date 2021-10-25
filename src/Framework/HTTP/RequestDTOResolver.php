<?php
declare(strict_types=1);

namespace RecruitmentApp\Framework\HTTP;

use RecruitmentApp\Framework\DTO\CreateUserRequest;
use RecruitmentApp\Framework\Exception\UserValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestDTOResolver implements ArgumentValueResolverInterface
{
    private ValidatorInterface $validator;
    
    public function __construct()
    {
        $this->validator = Validation::createValidator();
    }
    
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return CreateUserRequest::class === $argument->getType();
    }
    
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $dto = new CreateUserRequest($request);
        $violation = $this->validator->validate($dto);
        
        if (0 < count($violation)) throw new UserValidationException($this->extractErrorsFromViolationList($violation));
        
        yield $dto;
    }
    
    private function extractErrorsFromViolationList(ConstraintViolationListInterface $violations): string
    {
        $errors = '';
        
        /** @var ConstraintViolation $violation */
        foreach ($violations as $key => $violation) {
            $errors .= $key . '. ' . $violation->getMessage();
        }
        
        return $errors;
    }
}
