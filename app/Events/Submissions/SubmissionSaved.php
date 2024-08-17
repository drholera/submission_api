<?php

namespace App\Events\Submissions;

use Illuminate\Foundation\Events\Dispatchable;

class SubmissionSaved
{
    use Dispatchable;

    /**
     * @param int $id
     * @param string $name
     * @param string $message
     */
    public function __construct(
        private readonly int $id,
        private readonly string $name,
        private readonly string $message
    ) {
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
