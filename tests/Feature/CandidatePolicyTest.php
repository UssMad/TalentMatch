<?php

use App\Models\Candidate;
use App\Models\JobOffer;
use App\Models\User;
use App\Policies\CandidatePolicy;

beforeEach(function () {
    $this->policy = new CandidatePolicy;
});

test('viewAny returns true for job offer owner', function () {
    $user = User::factory()->create();
    $jobOffer = JobOffer::factory()->create(['user_id' => $user->id]);

    expect($this->policy->viewAny($user, $jobOffer))->toBeTrue();
});

test('viewAny returns false for non-owner', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $jobOffer = JobOffer::factory()->create(['user_id' => $owner->id]);

    expect($this->policy->viewAny($other, $jobOffer))->toBeFalse();
});

test('view returns true for job offer owner', function () {
    $user = User::factory()->create();
    $jobOffer = JobOffer::factory()->create(['user_id' => $user->id]);
    $candidate = Candidate::factory()->create(['job_offer_id' => $jobOffer->id]);

    expect($this->policy->view($user, $candidate))->toBeTrue();
});

test('view returns false for non-owner', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $jobOffer = JobOffer::factory()->create(['user_id' => $owner->id]);
    $candidate = Candidate::factory()->create(['job_offer_id' => $jobOffer->id]);

    expect($this->policy->view($other, $candidate))->toBeFalse();
});

test('create returns true for job offer owner', function () {
    $user = User::factory()->create();
    $jobOffer = JobOffer::factory()->create(['user_id' => $user->id]);

    expect($this->policy->create($user, $jobOffer))->toBeTrue();
});

test('create returns false for non-owner', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $jobOffer = JobOffer::factory()->create(['user_id' => $owner->id]);

    expect($this->policy->create($other, $jobOffer))->toBeFalse();
});

test('update returns true for job offer owner', function () {
    $user = User::factory()->create();
    $jobOffer = JobOffer::factory()->create(['user_id' => $user->id]);
    $candidate = Candidate::factory()->create(['job_offer_id' => $jobOffer->id]);

    expect($this->policy->update($user, $candidate))->toBeTrue();
});

test('update returns false for non-owner', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $jobOffer = JobOffer::factory()->create(['user_id' => $owner->id]);
    $candidate = Candidate::factory()->create(['job_offer_id' => $jobOffer->id]);

    expect($this->policy->update($other, $candidate))->toBeFalse();
});

test('delete returns true for job offer owner', function () {
    $user = User::factory()->create();
    $jobOffer = JobOffer::factory()->create(['user_id' => $user->id]);
    $candidate = Candidate::factory()->create(['job_offer_id' => $jobOffer->id]);

    expect($this->policy->delete($user, $candidate))->toBeTrue();
});

test('delete returns false for non-owner', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $jobOffer = JobOffer::factory()->create(['user_id' => $owner->id]);
    $candidate = Candidate::factory()->create(['job_offer_id' => $jobOffer->id]);

    expect($this->policy->delete($other, $candidate))->toBeFalse();
});
