<?php declare(strict_types=1);

namespace App\ApiResource;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class CreateUserProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager, // autowire comme poour votre command
        private UserPasswordHasherInterface $hasher, // autowire comme poour votre command
    ) {
    }

    /** @param CreateUser $data */
    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): User {
        // les datas envoyés dans le POST sont stockés dans $data !
        // Vous pouvez reprendre la logique de votre commande pour
        // créer votre user (avec un mot de passe hashé)

        $email = $data->email;
        $password = $data->password;

        $user = new User();
        $user->email = $email;
        $user->password = $this->hasher->hashPassword($user, $password);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;

        // votre logique
    }
}
