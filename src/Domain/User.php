<?php
declare(strict_types=1);

namespace RecruitmentApp\Domain;

use Doctrine\ORM\Mapping as ORM;
use RecruitmentApp\Domain\User\ApiKey;

/**
 * @ORM\Entity(repositoryClass="RecruitmentApp\Framework\Repository\UserRepository")
 * @ORM\Table(name="users")
 */
class User extends AbstractEntity implements \JsonSerializable
{
    /**
     * @ORM\Embedded(class="RecruitmentApp\Domain\Email", columnPrefix=false)
     */
    private Email $email;
    
    /**
     * @ORM\Embedded(class="RecruitmentApp\Domain\User\ApiKey", columnPrefix=false)
     */
    private ApiKey $apiKey;
    
    public function __construct(Email $email, ApiKey $apiKey)
    {
        $this->email = $email;
        $this->apiKey = $apiKey;
    }
    
    public function jsonSerialize(): array
    {
        return [
            'email' => (string) $this->email,
            'api_key' => (string) $this->apiKey,
        ];
    }
    
    public function getEmail(): string
    {
        return (string) $this->email;
    }
    
    public function setEmail(string $email)
    {
        $this->email = new Email($email);
    }
    
    public function __toString(): string
    {
        return (string) $this->apiKey;
    }
}
