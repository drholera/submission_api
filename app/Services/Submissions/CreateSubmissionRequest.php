<?php

namespace App\Services\Submissions;

class CreateSubmissionRequest
{
    /**
     * @param string $name
     * @param string $email
     * @param string $message
     */
    public function __construct(
        private string $name,
        private string $email,
        private string $message
    ) {}

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
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
