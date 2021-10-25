<?php
declare(strict_types=1);

namespace RecruitmentApp\Framework\Message;

use RecruitmentApp\Framework\DTO\CreateUserRequest;

class UserMessage
{
    private CreateUserRequest $request;
    
    public function __construct(CreateUserRequest $request)
    {
        $this->request = $request;
    }
    
    public function getCreateUserRequest(): CreateUserRequest
    {
        return $this->request;
    }
}
