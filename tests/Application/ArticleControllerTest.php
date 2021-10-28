<?php
declare(strict_types=1);

namespace Tests\Application;

use RecruitmentApp\Domain\Article;

class ArticleControllerTest extends TestAbstractApplication
{
    public function testCreateArticle(): void
    {
        $userApiKey = $this->getNewUserApiKeys();
        $this->createArticle($userApiKey, 'test_title', 'test_content');
        self::assertResponseIsSuccessful();
        
        /** @var Article|null $article */
        $article = $this->articleRepository->findOneBy(['content' => 'test_content', 'title' => 'test_title']);
        
        $this->assertNotNull($article);
        $this->assertEquals(UsersControllerTest::TEST_USER_EMAIL, $article->getAuthor()->getEmail());
    }
    
    public function testGetArticlesList(): void
    {
        $userApiKey = $this->getNewUserApiKeys();
        
        for($i=1; $i<=11; $i++) {
            $this->createArticle($userApiKey, (string) $i, (string) $i);
        }
        
        $this->client->request(
            method: 'GET',
            uri: '/articles',
            server: ['HTTP_API_KEY' => $userApiKey],
        );
        
        self::assertResponseIsSuccessful();
        $response = (array) json_decode($this->client->getResponse()->getContent());
        
        $this->assertGreaterThan(2, (int) $response['total_page']);
        $this->assertEquals(1, (int) $response['current_page']);
        $this->assertEquals(5, count((array) $response['content']));
    }
}
