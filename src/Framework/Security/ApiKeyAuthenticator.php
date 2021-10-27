<?php
declare(strict_types=1);

namespace RecruitmentApp\Framework\Security;

use RecruitmentApp\Framework\Repository\UserRepository;
use RecruitmentApp\Framework\Security\Badge\SimpleUserBadge;
use RecruitmentApp\Framework\Security\Passport\SimpleUserPassport;
use RecruitmentApp\Framework\Security\Token\PostAuthSimpleToken;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\LogicException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;

class ApiKeyAuthenticator extends AbstractAuthenticator
{
    private UserRepository $userRepository;
    public const ROLE_USER = ['ROLE_USER'];
    
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    
    public function supports(Request $request): ?bool
    {
        return $request->headers->has('API_KEY');
    }
    
    public function authenticate(Request $request): PassportInterface
    {
        $apiToken = $request->headers->get('API_KEY');
        
        if (null === $apiToken) {
            throw new CustomUserMessageAuthenticationException('No API token provided');
        }
        
        return new SimpleUserPassport(new SimpleUserBadge($apiToken, function ($apiToken) {
            return $this->userRepository->findOneBy(['apiKey.key' => $apiToken]);
        }));
    }
    
    /**
     * @param PassportInterface $passport
     * @param string $firewallName
     * @return TokenInterface
     */
    public function createAuthenticatedToken(PassportInterface $passport, string $firewallName): TokenInterface
    {
        if (!$passport instanceof SimpleUserPassport) {
            throw new LogicException(sprintf('Passport does not contain a user, overwrite "createAuthenticatedToken()" in "%s" to create a custom authenticated token.', static::class));
        }
        
        return new PostAuthSimpleToken($passport->getUser(), $firewallName, self::ROLE_USER);
    }
    
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }
    
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $data = ['message' => strtr($exception->getMessageKey(), $exception->getMessageData())];
        
        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }
}
