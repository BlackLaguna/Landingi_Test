<?php
declare(strict_types=1);

namespace RecruitmentApp\Framework\MessageHandler;

use RecruitmentApp\Domain\User;
use RecruitmentApp\Framework\Factory\UserFactory;
use RecruitmentApp\Framework\Message\UserMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UserMessageHandler implements MessageHandlerInterface
{
    private UserFactory $userFactory;
    
    public function __construct(UserFactory $userFactory)
    {
        $this->userFactory = $userFactory;
    }
    
    public function __invoke(UserMessage $message): User
    {
        return $this->userFactory->createFromRequest($message->getCreateUserRequest());
    }
}
