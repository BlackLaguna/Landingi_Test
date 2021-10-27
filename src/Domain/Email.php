<?php
declare(strict_types=1);

namespace RecruitmentApp\Domain;

use Doctrine\ORM\Mapping as ORM;
use RecruitmentApp\Domain\Email\Exception\InvalidEmail;

/**
 * @ORM\Embeddable
 */
class Email
{
    /**
     * @ORM\Column(type = "string", length=255)
     */
    private string $email;

    public function __construct(string $email)
    {
        if (empty($email) || false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmail(sprintf('Invalid email: "%s"', $email));
        }
        
        $this->email = $email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    
    public function getEmail(): string
    {
        return $this->email;
    }
    
    public function __toString()
    {
        return $this->email;
    }
}
