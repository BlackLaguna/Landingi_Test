<?php
declare(strict_types=1);

namespace RecruitmentApp\Domain;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="article")
 */
class Article implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private ?int $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", cascade={"DELETE"})
     */
    private User $author;
    
    /**
     * @ORM\Column(name="title", type="string", nullable=true)
     */
    private string $title;
    
    /**
     * @ORM\Column(name="content", type="string", nullable=true)
     */
    private string $content;
    
    public function getId(): int
    {
        return $this->id;
    }
    
    public function getAuthor(): User
    {
        return $this->author;
    }
    
    public function setAuthor(User $author): void
    {
        $this->author = $author;
    }
    
    public function getTitle(): string
    {
        return $this->title;
    }
    
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
    
    public function getContent(): string
    {
        return $this->content;
    }
    
    public function setContent(string $content): void
    {
        $this->content = $content;
    }
    
    public function jsonSerialize()
    {
        return [
            'author' => $this->author->jsonSerialize(),
            'title' => $this->title,
            'content' => $this->content,
        ];
    }
}
