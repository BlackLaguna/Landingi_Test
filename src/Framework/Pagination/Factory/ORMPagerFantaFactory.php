<?php

namespace RecruitmentApp\Framework\Pagination\Factory;

use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

class ORMPagerFantaFactory
{
    public function create(QueryBuilder $queryBuilder, int $page, int $maxPerPage = 5): Pagerfanta
    {
        $adapter = new QueryAdapter($queryBuilder, false);
        $pagerfanta = new Pagerfanta($adapter);

        $pagerfanta->setMaxPerPage($maxPerPage);
        $pagerfanta->setCurrentPage($page);
        
        return $pagerfanta;
    }
}
