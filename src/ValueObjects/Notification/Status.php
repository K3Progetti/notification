<?php


namespace Esc\Notification\ValueObjects\Notification;

use Esc\Notification\Entity\Notification;
use Assert\Assertion;
use Assert\AssertionFailedException;

class Status
{
    private $status;

    /**
     * Status constructor.
     * @param string|null $status
     * @throws AssertionFailedException
     */
    public function __construct(?string $status)
    {
        if ($status === null) {
            $status = Notification::SUBMITTED_STATE;
        }
        Assertion::inArray(
            $status,
            [
                Notification::SUBMITTED_STATE,
                Notification::ERROR_STATE,
                Notification::RUNNING_STATE,
                Notification::SUCCESS_STATE
            ]
        );
        $this->status = $status;
    }

    public function __toString()
    {
        //Force string return even if null status was handled before
        return (string) $this->status;
    }
}
