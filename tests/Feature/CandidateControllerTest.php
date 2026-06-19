<?php

use App\Models\Candidate;
use App\Models\JobOffer;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('index page displays candidates for the job offer', function () {
    $jobOffer = JobOffer::factory()->create(['user_id' => $this->user->id]);
    $candidate = Candidate::factory()->create(['job_offer_id' => $jobOffer->id]);

    $response = $this->get(route('job-offers.candidates.index', $jobOffer));

    $response->assertOk();
    $response->assertSee($candidate->name);
});

test('index page shows empty state', function () {
    $jobOffer = JobOffer::factory()->create(['user_id' => $this->user->id]);

    $response = $this->get(route('job-offers.candidates.index', $jobOffer));

    $response->assertOk();
    $response->assertSee('No candidates yet');
});

test('index returns 403 for non-owner', function () {
    $other = User::factory()->create();
    $jobOffer = JobOffer::factory()->create(['user_id' => $other->id]);

    $response = $this->get(route('job-offers.candidates.index', $jobOffer));

    $response->assertForbidden();
});

test('create page renders form', function () {
    $jobOffer = JobOffer::factory()->create(['user_id' => $this->user->id]);

    $response = $this->get(route('job-offers.candidates.create', $jobOffer));

    $response->assertOk();
    $response->assertSee('Add Candidate');
});

test('create returns 403 for non-owner', function () {
    $other = User::factory()->create();
    $jobOffer = JobOffer::factory()->create(['user_id' => $other->id]);

    $response = $this->get(route('job-offers.candidates.create', $jobOffer));

    $response->assertForbidden();
});

test('store creates a new candidate', function () {
    $jobOffer = JobOffer::factory()->create(['user_id' => $this->user->id]);

    $response = $this->post(route('job-offers.candidates.store', $jobOffer), [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '1234567890',
        'cv_text' => 'Experienced Laravel developer.',
    ]);

    $response->assertRedirect(route('job-offers.candidates.index', $jobOffer));
    $this->assertDatabaseHas('candidates', [
        'name' => 'John Doe',
        'job_offer_id' => $jobOffer->id,
    ]);
});

test('store returns 403 for non-owner', function () {
    $other = User::factory()->create();
    $jobOffer = JobOffer::factory()->create(['user_id' => $other->id]);

    $response = $this->post(route('job-offers.candidates.store', $jobOffer), [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'cv_text' => 'Experienced Laravel developer.',
    ]);

    $response->assertForbidden();
});

test('store validates required fields', function () {
    $jobOffer = JobOffer::factory()->create(['user_id' => $this->user->id]);

    $response = $this->post(route('job-offers.candidates.store', $jobOffer), []);

    $response->assertSessionHasErrors(['name', 'email', 'cv_text']);
});

test('store validates email format', function () {
    $jobOffer = JobOffer::factory()->create(['user_id' => $this->user->id]);

    $response = $this->post(route('job-offers.candidates.store', $jobOffer), [
        'name' => 'John Doe',
        'email' => 'not-an-email',
        'cv_text' => 'Experienced Laravel developer.',
    ]);

    $response->assertSessionHasErrors(['email']);
});

test('show page displays candidate details', function () {
    $jobOffer = JobOffer::factory()->create(['user_id' => $this->user->id]);
    $candidate = Candidate::factory()->create(['job_offer_id' => $jobOffer->id]);

    $response = $this->get(route('job-offers.candidates.show', [$jobOffer, $candidate]));

    $response->assertOk();
    $response->assertSee($candidate->name);
    $response->assertSee($candidate->email);
});

test('show returns 403 for non-owner', function () {
    $other = User::factory()->create();
    $jobOffer = JobOffer::factory()->create(['user_id' => $other->id]);
    $candidate = Candidate::factory()->create(['job_offer_id' => $jobOffer->id]);

    $response = $this->get(route('job-offers.candidates.show', [$jobOffer, $candidate]));

    $response->assertForbidden();
});

test('edit page displays form with existing data', function () {
    $jobOffer = JobOffer::factory()->create(['user_id' => $this->user->id]);
    $candidate = Candidate::factory()->create(['job_offer_id' => $jobOffer->id]);

    $response = $this->get(route('job-offers.candidates.edit', [$jobOffer, $candidate]));

    $response->assertOk();
    $response->assertSee($candidate->name);
});

test('edit returns 403 for non-owner', function () {
    $other = User::factory()->create();
    $jobOffer = JobOffer::factory()->create(['user_id' => $other->id]);
    $candidate = Candidate::factory()->create(['job_offer_id' => $jobOffer->id]);

    $response = $this->get(route('job-offers.candidates.edit', [$jobOffer, $candidate]));

    $response->assertForbidden();
});

test('update modifies a candidate', function () {
    $jobOffer = JobOffer::factory()->create(['user_id' => $this->user->id]);
    $candidate = Candidate::factory()->create(['job_offer_id' => $jobOffer->id]);

    $response = $this->put(route('job-offers.candidates.update', [$jobOffer, $candidate]), [
        'name' => 'Updated Name',
        'email' => 'updated@example.com',
        'cv_text' => 'Updated CV text.',
    ]);

    $response->assertRedirect(route('job-offers.candidates.index', $jobOffer));
    $this->assertDatabaseHas('candidates', [
        'id' => $candidate->id,
        'name' => 'Updated Name',
    ]);
});

test('update returns 403 for non-owner', function () {
    $other = User::factory()->create();
    $jobOffer = JobOffer::factory()->create(['user_id' => $other->id]);
    $candidate = Candidate::factory()->create(['job_offer_id' => $jobOffer->id]);

    $response = $this->put(route('job-offers.candidates.update', [$jobOffer, $candidate]), [
        'name' => 'Hacked',
        'email' => 'hacked@example.com',
        'cv_text' => 'Hacked CV.',
    ]);

    $response->assertForbidden();
});

test('destroy deletes a candidate', function () {
    $jobOffer = JobOffer::factory()->create(['user_id' => $this->user->id]);
    $candidate = Candidate::factory()->create(['job_offer_id' => $jobOffer->id]);

    $response = $this->delete(route('job-offers.candidates.destroy', [$jobOffer, $candidate]));

    $response->assertRedirect(route('job-offers.candidates.index', $jobOffer));
    $this->assertDatabaseMissing('candidates', ['id' => $candidate->id]);
});

test('destroy returns 403 for non-owner', function () {
    $other = User::factory()->create();
    $jobOffer = JobOffer::factory()->create(['user_id' => $other->id]);
    $candidate = Candidate::factory()->create(['job_offer_id' => $jobOffer->id]);

    $response = $this->delete(route('job-offers.candidates.destroy', [$jobOffer, $candidate]));

    $response->assertForbidden();
});

test('unauthenticated user is redirected to login', function () {
    auth()->logout();
    $jobOffer = JobOffer::factory()->create();

    $response = $this->get(route('job-offers.candidates.index', $jobOffer));

    $response->assertRedirect(route('login'));
});
