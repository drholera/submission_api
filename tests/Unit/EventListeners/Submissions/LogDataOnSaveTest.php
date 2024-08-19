<?php

namespace Tests\Unit\EventListeners\Submissions;

use App\EventListeners\Submissions\LogDataOnSave;
use App\Events\Submissions\SubmissionSaved;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class LogDataOnSaveTest extends TestCase
{

    private $logger;

    /**
     * @return void
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->logger = $this->createMock(LoggerInterface::class);
    }

    /**
     * @return void
     */
    public function testHandle(): void
    {
        $submissionId = 123;
        $submissionName = 'Test Name';
        $submissionMessage = 'Test Message';

        $event = new SubmissionSaved($submissionId, $submissionName, $submissionMessage);

        $this->logger->expects($this->once())
            ->method('info')
            ->with(
                $this->stringContains(
                    'Submission ' . $submissionId . ' was successfully saved. Name: ' . $submissionName . ', Email: ' . $submissionMessage
                )
            );

        $logDataOnSave = new LogDataOnSave($this->logger);
        $logDataOnSave->handle($event);
    }
}
