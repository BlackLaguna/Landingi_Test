<?php
declare(strict_types=1);

namespace RecruitmentApp\Framework\DTO;

use Symfony\Component\HttpFoundation\Request;

class CreateArticleRequest implements DTORequestInterface
{
    private string $content;
    private string $title;
    
    public function __construct(Request $request)
    {
        $this->content = $request->query->getAlnum('content');
        $this->title = $request->query->getAlnum('title');
    }
    
    public function getContent(): ?string
    {
        return $this->content;
    }
    
    public function getTitle(): ?string
    {
        return $this->title;
    }
}
