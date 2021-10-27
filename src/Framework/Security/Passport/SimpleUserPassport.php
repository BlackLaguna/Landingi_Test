<?php
declare(strict_types=1);

namespace RecruitmentApp\Framework\Security\Passport;

use phpDocumentor\Reflection\Types\Mixed_;
use RecruitmentApp\Domain\User;
use RecruitmentApp\Framework\Security\Badge\SimpleUserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\BadgeInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportTrait;

class SimpleUserPassport implements PassportInterface
{
    use PassportTrait;
    
    private ?User $user;
    private array $attributes = [];
    
    /**
     * @param BadgeInterface[] $badges
     */
    public function __construct(SimpleUserBadge $userBadge, array $badges = [])
    {
        $this->user = null;
        $this->addBadge($userBadge);
        
        foreach ($badges as $badge) {
            $this->addBadge($badge);
        }
    }
    
    public function getUser(): User
    {
        if (null === $this->user) {
            if (!$this->hasBadge(SimpleUserBadge::class)) {
                throw new \LogicException('Cannot get the Security user, no username or UserBadge configured for this passport.');
            }
            
            $this->user = $this->getBadge(SimpleUserBadge::class)->getUser();
        }
        
        return $this->user;
    }
    
    public function setAttribute(string $name, Mixed_ $value): void
    {
        $this->attributes[$name] = $value;
    }
    
    public function getAttribute(string $name, Mixed_ $default = null)
    {
        return $this->attributes[$name] ?? $default;
    }
}
