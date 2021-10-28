<?php
declare(strict_types=1);

namespace Tests\Application;

class UsersControllerTest extends TestAbstractApplication
{
    public const TEST_USER_EMAIL = 'email@domain.com';
    
    public function testCreateUser(): void
    {
        $userApiKey = $this->getNewUserApiKeys();
        self::assertResponseIsSuccessful();
        $this->assertNotNull($this->userRepository->findOneBy(['apiKey.key' => $userApiKey]));
    }
    
    public function testDeleteUser(): void
    {
        $userApiKey = $this->getNewUserApiKeys();
        $this->createArticle($userApiKey, 'test', 'test');
        $this->assertNotNull($this->userRepository->findOneBy(['apiKey.key' => $userApiKey]));
        $this->assertNotNull($this->articleRepository->findOneBy(['title' => 'test', 'content' => 'test']));
        
        $this->client->request(
            method: 'DELETE',
            uri: '/users',
            server: ['HTTP_API_KEY' => $userApiKey],
        );
        
        $this->assertNull($this->userRepository->findOneBy(['apiKey.key' => $userApiKey]));
        $this->assertNull($this->articleRepository->findOneBy(['title' => 'test', 'content' => 'test']));
    }
}
