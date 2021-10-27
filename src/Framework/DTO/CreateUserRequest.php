<?php
declare(strict_types=1);

namespace RecruitmentApp\Framework\DTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CreateUserRequest implements DTORequestInterface
{
    /**
     * @Assert\Email(message="The email '{{ value }}' is not a valid email.")
     */
    private string $email;
    
    public function __construct(Request $request)
    {
        $this->email = $request->get('email');
    }
    
    public function getEmail(): ?string
    {
        return $this->email;
    }
}
