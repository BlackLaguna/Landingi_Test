<?php
declare(strict_types=1);

namespace RecruitmentApp\Domain;

use Doctrine\ORM\Mapping as ORM;
use RecruitmentApp\Domain\User\ApiKey;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;
    
    /**
     * @ORM\Column(type="string", length=255)
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
}
