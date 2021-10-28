<?php
declare(strict_types=1);

namespace Tests\Application;

use RecruitmentApp\Domain\Article;
use RecruitmentApp\Domain\User;
use RecruitmentApp\Framework\Repository\ArticleRepository;
use RecruitmentApp\Framework\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TestAbstractApplication extends WebTestCase
{
    protected KernelBrowser $client;
    protected UserRepository $userRepository;
    protected ArticleRepository $articleRepository;
    
    protected function setUp(): void
    {
        $this->client = self::createClient();
        $this->articleRepository = self::getContainer()->get('doctrine.orm.entity_manager')->getRepository(Article::class);
        $this->userRepository = self::getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
    }
    
    protected function getNewUserApiKeys(): string
    {
        $this->client->request(
            method: 'POST',
            uri: '/users',
            parameters: ['email' => UsersControllerTest::TEST_USER_EMAIL],
            server: [],
        );
        
        $responseContent = (array) json_decode($this->client->getResponse()->getContent());
        
        return $responseContent['api_key'];
    }
    
    protected function createArticle(string $userApiKey, string $title, string $content): void
    {
        $this->client->request(
            method: 'POST',
            uri: '/articles',
            server: ['HTTP_API_KEY' => $userApiKey],
            content: json_encode(['title' => $title, 'content' => $content]),
        );
    }
}
