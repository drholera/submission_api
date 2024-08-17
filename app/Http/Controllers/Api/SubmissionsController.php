<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\InvalidSubmissionArgumentException;
use App\Http\Controllers\Controller;
use App\Services\Submissions\CreateSubmission;
use App\Services\Submissions\CreateSubmissionRequest;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubmissionsController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    public function __construct(private readonly CreateSubmission $createSubmission)
    {}

    public function submit(Request $httpRequest): JsonResponse
    {
        $request = $this->buildRequest($httpRequest);

        $result = $this->createSubmission->execute($request);

        if ($result instanceof PendingDispatch) {
            return response()->json('Submission creation was scheduled successfully');
        }

        return response()->json('Error, something went wrong', 500);
    }

    /**
     * @param Request $httpRequest
     * @return CreateSubmissionRequest
     */
    private function buildRequest(Request $httpRequest): CreateSubmissionRequest
    {
        try {
            $httpRequest->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|max:255',
                'message' => 'required',
            ]);
        } catch (\Throwable $th) {
            throw new InvalidSubmissionArgumentException(400, $th->getMessage());
        }

        return new CreateSubmissionRequest(
            $httpRequest->get('name'),
            $httpRequest->get('email'),
            $httpRequest->get('message')
        );
    }
}
