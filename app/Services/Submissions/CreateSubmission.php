<?php

namespace App\Services\Submissions;

use App\Jobs\CreateSubmissionJob;
use Illuminate\Foundation\Bus\PendingDispatch;

class CreateSubmission
{
    /**
     * @param CreateSubmissionRequest $request
     * @return PendingDispatch
     */
    public function execute(CreateSubmissionRequest $request)
    {
        return CreateSubmissionJob::dispatch(
            $request
        );
    }
}
