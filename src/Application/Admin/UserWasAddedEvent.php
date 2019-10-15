<?php
declare(strict_types=1);

namespace App\Application\Admin;

//use Symfony\Contracts\EventDispatcher\Event;

class UserWasAddedEvent
{
    private $username;

    public function __construct(string $username)
    {
        $this->username = $username;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
}
