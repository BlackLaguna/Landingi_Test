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
        $requestContent = (array) json_decode($request->getContent());
        $this->content = $requestContent['content'] ?? '';
        $this->title = $requestContent['title'] ?? '';
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
