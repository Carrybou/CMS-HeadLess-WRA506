<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Service\Tokens;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class LoginController extends AbstractController
{
    public function __construct(
        private Tokens $tokens,

)
    {
    }

    #[Route('/api/login', name: 'api_login', methods: ['POST', 'GET'])]
    public function index(#[CurrentUser] ?User $user): Response
    {
        if (null === $user) {
            throw $this->createAccessDeniedException();
        }
        try {
            $token = $this->tokens->generateTokenForUser($user->getEmail());
        } catch (\Exception $e) {

            return $this->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json(['token' => $token, 'user' => $user->getUserIdentifier()]);
    }
}
