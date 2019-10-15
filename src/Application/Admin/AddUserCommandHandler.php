<?php
declare(strict_types=1);

namespace App\Application\Admin;

use App\Infrastructure\DoctrinePGSQL\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AddUserCommandHandler
{
    private $encoder;
    private $em;
    private $eventDispatcher;

    public function __construct(UserPasswordEncoderInterface $encoder, EntityManagerInterface $em, EventDispatcherInterface $eventDispatcher)
    {
        $this->encoder = $encoder;
        $this->em = $em;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle(AddUserCommand $command)
    {
        $user = new User($command->getUsername());
        $user->setPassword($this->encoder->encodePassword($user, $command->getPassword()));
        $this->em->persist($user);
        $this->em->flush();

        $this->eventDispatcher->dispatch(new UserWasAddedEvent($command->getUsername()));
    }
}
