<?php

namespace App\Jobs;

use App\Events\Submissions\SubmissionSaved;
use App\Exceptions\JobHandlingException;
use App\Models\Submission;
use App\Services\Submissions\CreateSubmissionRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateSubmissionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly CreateSubmissionRequest $request)
    {}

    /**
     * @return void
     */
    public function handle()
    {
        try {
            $submission = Submission::create([
                'name' => $this->request->getName(),
                'email' => $this->request->getEmail(),
                'message' => $this->request->getMessage(),
            ]);

            SubmissionSaved::dispatch(
                $submission->id,
                $submission->name,
                $submission->email,
            );
        } catch (\Throwable $e) {
            throw new JobHandlingException($e->getMessage());
        }
    }
}
