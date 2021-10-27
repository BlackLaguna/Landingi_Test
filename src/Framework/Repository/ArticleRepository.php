<?php
declare(strict_types=1);

namespace RecruitmentApp\Framework\Repository;

use Doctrine\Persistence\ManagerRegistry;
use RecruitmentApp\Domain\Article;

class ArticleRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }
}
