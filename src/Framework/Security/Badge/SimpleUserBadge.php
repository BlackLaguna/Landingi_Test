<?php
declare(strict_types=1);

namespace RecruitmentApp\Framework\Security\Badge;

use phpDocumentor\Reflection\Types\Callable_;
use RecruitmentApp\Domain\User;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\AuthenticationServiceException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\BadgeInterface;
use Symfony\Component\Security\Http\EventListener\UserProviderListener;

class SimpleUserBadge implements BadgeInterface
{
    private ?User $user;
    private ?\Closure $userLoader;
    private string $userIdentifier;
    
    public function __construct(string $userIdentifier, callable $userLoader)
    {
        $this->userIdentifier = $userIdentifier;
        $this->userLoader = $userLoader;
        $this->user = null;
    }
    
    /**
     * @throws AuthenticationException when the user cannot be found
     */
    public function getUser(): User
    {
        if (null === $this->user) {
            if (null === $this->userLoader) {
                throw new \LogicException(sprintf('No user loader is configured, did you forget to register the "%s" listener?', UserProviderListener::class));
            }
            
            $this->user = ($this->userLoader)($this->userIdentifier);

            if (!$this->user instanceof User) {
                throw new AuthenticationServiceException(sprintf('The user provider must return a UserInterface object, "%s" given.', get_debug_type($this->user)));
            }
        }
        
        return $this->user;
    }
    
    public function getUserIdentifier(): string
    {
        return $this->userIdentifier;
    }
    
    public function getUserLoader(): ?callable
    {
        return $this->userLoader;
    }
    
    public function setUserLoader(callable $userLoader = null): void
    {
        $this->userLoader = $userLoader;
    }
    
    public function isResolved(): bool
    {
        return true;
    }
}
