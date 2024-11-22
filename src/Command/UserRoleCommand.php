<?php declare(strict_types=1);

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use function in_array;

/*
 * To add roles to a user:
 * php bin/console user:role user@example.com --add=ROLE_ADMIN --add=ROLE_MANAGER
 * To remove roles from a user:
 * php bin/console user:role user@example.com --remove=ROLE_ADMIN
 * */
#[AsCommand(
    name: 'user:role',
    description: 'Add or remove roles from a user',
)]
class UserRoleCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'The email of the user')
            ->addOption('add', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Roles to add')
            ->addOption('remove', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Roles to remove');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        $rolesToAdd = $input->getOption('add');
        $rolesToRemove = $input->getOption('remove');

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

        if (!$user) {
            $io->error("User with email {$email} not found.");

            return Command::FAILURE;
        }

        $currentRoles = $user->getRoles();

        if ($rolesToAdd) {
            foreach ($rolesToAdd as $role) {
                if (!in_array($role, $currentRoles)) {
                    $currentRoles[] = $role;
                }
            }
        }

        if ($rolesToRemove) {
            $currentRoles = array_diff($currentRoles, $rolesToRemove);
        }

        $user->setRoles($currentRoles);
        $this->entityManager->flush();

        $io->success("Roles updated successfully for user {$email}. Current roles: " . implode(', ', $currentRoles));

        return Command::SUCCESS;
    }
}
