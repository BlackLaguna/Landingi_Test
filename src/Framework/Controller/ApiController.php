<?php
declare(strict_types=1);

namespace RecruitmentApp\Framework\Controller;

use Pagerfanta\Pagerfanta;
use RecruitmentApp\Framework\Pagination\Factory\ORMPagerFantaFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class ApiController extends AbstractController
{
    protected ORMPagerFantaFactory $pagerFantaFactory;
    
    public function __construct(ORMPagerFantaFactory $pagerFantaFactory)
    {
        $this->pagerFantaFactory = $pagerFantaFactory;
    }
    
    protected function createPaginated(string $className, int $page = 1, int $perPage = 5): Pagerfanta
    {
        return $this->pagerFantaFactory->create(
            $this->getDoctrine()->getRepository($className)->queryAll(),
            $page,
            $perPage
        );
    }
}
