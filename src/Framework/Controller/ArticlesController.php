<?php
declare(strict_types=1);

namespace RecruitmentApp\Framework\Controller;

use JetBrains\PhpStorm\Pure;
use RecruitmentApp\Domain\Article;
use RecruitmentApp\Framework\DTO\CreateArticleRequest;
use RecruitmentApp\Framework\Factory\ArticleFactory;
use RecruitmentApp\Framework\Pagination\Factory\ORMPagerFantaFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/articles')]
class ArticlesController extends ApiController
{
    private ArticleFactory $articleFactory;
    
    #[Pure] function __construct(ORMPagerFantaFactory $pagerFantaFactory, ArticleFactory $articleFactory)
    {
        parent::__construct($pagerFantaFactory);
        $this->articleFactory = $articleFactory;
    }
    
    #[Route(name: 'create_article', methods: ['POST'])]
    public function create(CreateArticleRequest $request): JsonResponse
    {
        $this->articleFactory->setCurrentUser($this->getUser());
        $article = $this->articleFactory->createFromDTO($request);
        
        return new JsonResponse($article, Response::HTTP_CREATED);
    }
    
    #[Route(name: 'get_article_list', methods: ['GET'])]
    public function getList(Request $request): JsonResponse
    {
        $pagerFanta = $this->createPaginated(Article::class, $request->query->getInt('page', 1));
        
        return new JsonResponse($pagerFanta->getCurrentPageResults());
    }
}
