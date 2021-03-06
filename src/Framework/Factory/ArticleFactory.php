<?php
declare(strict_types=1);

namespace RecruitmentApp\Framework\Factory;

use RecruitmentApp\Domain\Article;
use RecruitmentApp\Domain\User;
use RecruitmentApp\Framework\DTO\CreateArticleRequest;
use RecruitmentApp\Framework\DTO\DTORequestInterface;

class ArticleFactory extends AbstractFactory
{
    /** @var User|null|object  */
    private $currentUser = null;
    
    /**
     * @param CreateArticleRequest $DTO
     * @return Article
     */
    public function createFromDTO(DTORequestInterface $DTO): Article
    {
        $article = new Article();
        
        $article->setContent($DTO->getContent());
        $article->setTitle($DTO->getTitle());
        $article->setAuthor($this->currentUser);
        
        $this->entityManager->persist($article);
        $this->entityManager->flush();
    
        return $article;
    }
    
    /**
     * @param object|User $user
     */
    public function setCurrentUser($user): void
    {
        $this->currentUser = $user;
    }
}
