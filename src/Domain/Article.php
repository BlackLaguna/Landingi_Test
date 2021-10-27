<?php
declare(strict_types=1);

namespace RecruitmentApp\Domain;

use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Object_;

/**
 * @ORM\Entity(repositoryClass="RecruitmentApp\Framework\Repository\ArticleRepository")
 * @ORM\Table(name="article")
 */
class Article extends AbstractEntity implements \JsonSerializable
{
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="articles", cascade={"remove"})
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
    
    public function getAuthor(): User
    {
        return $this->author;
    }
    
    /**
     * @param User $author
     */
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
            'author' => $this->author->getEmail(),
            'title' => $this->title,
            'content' => $this->content,
        ];
    }
}
