<?php

use App\Models\JobOffer;
use App\Models\User;
use App\Policies\JobOfferPolicy;

beforeEach(function () {
    $this->policy = new JobOfferPolicy;
});

test('viewAny returns true for any user', function () {
    $user = User::factory()->create();

    expect($this->policy->viewAny($user))->toBeTrue();
});

test('view returns true for owner', function () {
    $user = User::factory()->create();
    $jobOffer = JobOffer::factory()->create(['user_id' => $user->id]);

    expect($this->policy->view($user, $jobOffer))->toBeTrue();
});

test('view returns false for non-owner', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $jobOffer = JobOffer::factory()->create(['user_id' => $owner->id]);

    expect($this->policy->view($other, $jobOffer))->toBeFalse();
});

test('create returns true for any user', function () {
    $user = User::factory()->create();

    expect($this->policy->create($user))->toBeTrue();
});

test('update returns true for owner', function () {
    $user = User::factory()->create();
    $jobOffer = JobOffer::factory()->create(['user_id' => $user->id]);

    expect($this->policy->update($user, $jobOffer))->toBeTrue();
});

test('update returns false for non-owner', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $jobOffer = JobOffer::factory()->create(['user_id' => $owner->id]);

    expect($this->policy->update($other, $jobOffer))->toBeFalse();
});

test('delete returns true for owner', function () {
    $user = User::factory()->create();
    $jobOffer = JobOffer::factory()->create(['user_id' => $user->id]);

    expect($this->policy->delete($user, $jobOffer))->toBeTrue();
});

test('delete returns false for non-owner', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $jobOffer = JobOffer::factory()->create(['user_id' => $owner->id]);

    expect($this->policy->delete($other, $jobOffer))->toBeFalse();
});

test('modify returns true for owner', function () {
    $user = User::factory()->create();
    $jobOffer = JobOffer::factory()->create(['user_id' => $user->id]);

    expect($this->policy->modify($user, $jobOffer))->toBeTrue();
});

test('modify returns false for non-owner', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $jobOffer = JobOffer::factory()->create(['user_id' => $owner->id]);

    expect($this->policy->modify($other, $jobOffer))->toBeFalse();
});
