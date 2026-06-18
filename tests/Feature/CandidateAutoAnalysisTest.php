<?php

use App\Jobs\RunAnalysisJob;
use App\Models\Candidate;
use App\Models\JobOffer;
use App\Models\User;
use Illuminate\Support\Facades\Queue;

beforeEach(function () {
    Queue::fake();
});

test('dispatches analysis job when candidate is created with cv_text', function () {
    $user = User::factory()->create();
    $jobOffer = JobOffer::factory()->create(['user_id' => $user->id]);

    $candidate = Candidate::factory()->create([
        'job_offer_id' => $jobOffer->id,
        'cv_text' => 'Experienced PHP developer with 5 years...',
    ]);

    Queue::assertPushed(RunAnalysisJob::class, function ($job) use ($candidate) {
        return $job->candidateId === $candidate->id;
    });
});

test('does not dispatch analysis job when candidate is created without cv_text', function () {
    $user = User::factory()->create();
    $jobOffer = JobOffer::factory()->create(['user_id' => $user->id]);

    $candidate = Candidate::factory()->create([
        'job_offer_id' => $jobOffer->id,
        'cv_text' => '',
    ]);

    Queue::assertNotPushed(RunAnalysisJob::class);
});

test('dispatches analysis job when cv_text is updated', function () {
    $user = User::factory()->create();
    $jobOffer = JobOffer::factory()->create(['user_id' => $user->id]);
    $candidate = Candidate::factory()->create([
        'job_offer_id' => $jobOffer->id,
        'cv_text' => 'Old CV text',
    ]);

    Queue::assertPushed(RunAnalysisJob::class);

    Queue::fake();

    $candidate->update(['cv_text' => 'New CV text with more experience...']);

    Queue::assertPushed(RunAnalysisJob::class, function ($job) use ($candidate) {
        return $job->candidateId === $candidate->id;
    });
});

test('does not dispatch job when non-CV fields are updated', function () {
    $user = User::factory()->create();
    $jobOffer = JobOffer::factory()->create(['user_id' => $user->id]);
    $candidate = Candidate::factory()->create([
        'job_offer_id' => $jobOffer->id,
        'cv_text' => 'Experienced PHP developer...',
    ]);

    Queue::assertPushed(RunAnalysisJob::class);

    Queue::fake();

    $candidate->update(['name' => 'New Name']);

    Queue::assertNotPushed(RunAnalysisJob::class);
});
