<?php declare(strict_types=1);

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Throwable;

#[AsCommand(
    name: 'user:create',
    description: 'Add a user to the bdd',
)]
class UserCreateCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption('email', null, InputOption::VALUE_REQUIRED);
        $this->addOption('password', null, InputOption::VALUE_REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $email = $input->getOption('email');
            $password = $input->getOption('password');

            $user = new User();
            $user->email = $email;
            $user->password = $this->passwordHasher->hashPassword($user, $password);
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $output->writeln("User {$user->email} created successfully !");

            return Command::SUCCESS;
        } catch (Throwable $e) {
            $output->writeln("Error: {$e->getMessage()}");

            return Command::FAILURE;
        }
    }
}
