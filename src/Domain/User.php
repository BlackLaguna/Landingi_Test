<?php
declare(strict_types=1);

namespace RecruitmentApp\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    
    /**
     * @ORM\OneToMany(targetEntity="Article", cascade={"remove"}, mappedBy="author")
     */
    private Collection $articles;
    
    public function __construct(Email $email, ApiKey $apiKey)
    {
        $this->email = $email;
        $this->apiKey = $apiKey;
        $this->articles = new ArrayCollection();
    }
    
    public function jsonSerialize(): array
    {
        return [
            'email' => (string) $this->email,
            'api_key' => (string) $this->apiKey,
        ];
    }
    
    public function addArticle(Article $article): void
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->setAuthor($this);
        }
    }
    
    public function getArticle(): Collection
    {
        return $this->articles;
    }
    
    public function getEmail(): string
    {
        return (string) $this->email;
    }
    
    public function setEmail(string $email): void
    {
        $this->email = new Email($email);
    }
    
    public function __toString(): string
    {
        return (string) $this->apiKey;
    }
}
