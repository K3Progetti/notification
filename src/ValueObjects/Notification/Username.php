<?php


namespace Esc\Notification\ValueObjects\Notification;

use Assert\Assertion;
use Assert\AssertionFailedException;

class Username
{
    /**
     * @var string
     */
    private $username;

    /**
     * Username constructor.
     * @param string $username
     * @throws AssertionFailedException
     */
    public function __construct(string $username)
    {
        Assertion::notEmpty($username);
        $this->username = $username;
    }

    public function __toString()
    {
        return $this->username;
    }
}
