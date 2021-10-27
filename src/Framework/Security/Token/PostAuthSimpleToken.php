<?php
declare(strict_types=1);

namespace RecruitmentApp\Framework\Security\Token;

use RecruitmentApp\Domain\User;
use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

class PostAuthSimpleToken extends AbstractToken
{
    private string $firewallName;
    
    /**
     * @param string[] $roles An array of roles
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(User $user, string $firewallName, array $roles)
    {
        parent::__construct($roles);
        
        if ('' === $firewallName) {
            throw new \InvalidArgumentException('$firewallName must not be empty.');
        }
        
        $this->setUser($user);
        $this->firewallName = $firewallName;
        $this->setAuthenticated(true);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getCredentials()
    {
        return [];
    }
    
    public function getFirewallName(): string
    {
        return $this->firewallName;
    }
    
    /**
     * {@inheritdoc}
     */
    public function __serialize(): array
    {
        return [$this->firewallName, parent::__serialize()];
    }
    
    /**
     * {@inheritdoc}
     */
    public function __unserialize(array $data): void
    {
        [$this->firewallName, $parentData] = $data;
        parent::__unserialize($parentData);
    }
}
