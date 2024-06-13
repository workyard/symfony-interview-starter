<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Command;

use App\Command\AddUserCommand;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class AddUserCommandTest extends AbstractCommandTest
{
    /**
     * @var string[]
     */
    private array $userData = [
        'first-name' => 'chuck',
        'last-name' => 'norris',
    ];

    protected function setUp(): void
    {
        if ('Windows' === \PHP_OS_FAMILY) {
            $this->markTestSkipped('`stty` is required to test this command.');
        }
    }

    public function testCreateUserNonInteractive(): void
    {
        $input = $this->userData;

        $this->executeCommand($input);

        $this->assertUserCreated();
    }

    public function testCreateUserInteractive(): void
    {
        $this->executeCommand(
            // these are the arguments (only 1 is passed, the rest are missing)
            [],
            // these are the responses given to the questions asked by the command
            // to get the value of the missing required arguments
            array_values($this->userData)
        );

        $this->assertUserCreated();
    }


    /**
     * This helper method checks that the user was correctly created and saved
     * in the database.
     */
    private function assertUserCreated(): void
    {
        /** @var UserRepository $repository */
        $repository = $this->getContainer()->get(UserRepository::class);

        $user = $repository->findOneByFirstName($this->userData['first-name']);

        $this->assertNotNull($user);
        $this->assertSame($this->userData['first-name'], $user->getFirstName());
        $this->assertSame($this->userData['last-name'], $user->getLastName());
    }

    protected function getCommandFqcn(): string
    {
        return AddUserCommand::class;
    }
}
