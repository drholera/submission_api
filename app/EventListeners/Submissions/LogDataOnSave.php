<?php

namespace App\EventListeners\Submissions;

use App\Events\Submissions\SubmissionSaved;
use Psr\Log\LoggerInterface;

class LogDataOnSave
{
    /**
     * @param LoggerInterface $logger
     */
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    /**
     * @param SubmissionSaved $event
     * @return void
     */
    public function handle(SubmissionSaved $event)
    {
        $this->logger->info(
            sprintf(
                'Submission %s was successfully saved. Name: %s, Email: %s',
                $event->getId(),
                $event->getName(),
                $event->getMessage()
            )
        );
    }
}
