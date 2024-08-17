<?php

namespace Tests\Feature;

use App\Services\Submissions\CreateSubmission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Bus\PendingDispatch;
use Mockery;
use Tests\TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

class SubmissionsControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker, MockeryPHPUnitIntegration;

    /**
     * Test that the submit method returns success when valid data is provided.
     *
     * @return void
     */
    public function test_submit_returns_success_when_valid_data_provided()
    {
        // Arrange
        $createSubmissionMock = Mockery::mock(CreateSubmission::class);
        $createSubmissionMock->shouldReceive('execute')
            ->once()
            ->andReturn(new PendingDispatch(new \stdClass()));

        $this->app->instance(CreateSubmission::class, $createSubmissionMock);

        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'message' => 'This is a test message.',
        ];

        // Act
        $response = $this->postJson('/api/submit', $data);

        // Assert
        $response->assertStatus(200)
            ->assertJson(['message' => 'Submission creation was scheduled successfully']);
    }

    /**
     * Test that the submit method returns 500 error when execution fails.
     *
     * @return void
     */
    public function test_submit_returns_error_when_execution_fails()
    {
        // Arrange
        $createSubmissionMock = Mockery::mock(CreateSubmission::class);
        $createSubmissionMock->shouldReceive('execute')
            ->once()
            ->andReturnNull();

        $this->app->instance(CreateSubmission::class, $createSubmissionMock);

        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'message' => 'This is a test message.',
        ];

        // Act
        $response = $this->postJson('/api/submit', $data);

        // Assert
        $response->assertStatus(500)
            ->assertJson(['message' => 'Error, something went wrong']);
    }

    /**
     * Test that the submit method throws validation exception when required fields are missing.
     *
     * @return void
     */
    public function test_submit_throws_validation_exception_when_required_fields_missing()
    {
        // Arrange
        $data = [
            'name' => '',  // Missing name
            'email' => '', // Invalid email
            'message' => '', // Missing message
        ];

        // Act
        $response = $this->postJson('/api/submit', $data);

        // Assert
        $response->assertStatus(400);
    }

    /**
     * Test that the submit method handles InvalidSubmissionArgumentException correctly.
     *
     * @return void
     */
    public function test_submit_handles_invalid_submission_argument_exception()
    {
        // Arrange
        $createSubmissionMock = Mockery::mock(CreateSubmission::class);
        $this->app->instance(CreateSubmission::class, $createSubmissionMock);

        $data = [
            'name' => 'John Doe',
            'email' => 'invalid-email', // Invalid email format
            'message' => 'This is a test message.',
        ];

        // Act
        $response = $this->postJson('/api/submit', $data);

        // Assert
        $response->assertStatus(400);
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
