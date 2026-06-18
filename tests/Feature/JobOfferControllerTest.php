<?php

use App\Models\JobOffer;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('index page displays user job offers', function () {
    $jobOffer = JobOffer::factory()->create(['user_id' => $this->user->id]);

    $response = $this->get(route('job-offers.index'));

    $response->assertOk();
    $response->assertSee($jobOffer->title);
});

test('index page shows empty state', function () {
    $response = $this->get(route('job-offers.index'));

    $response->assertOk();
    $response->assertSee('No job offers yet');
});

test('create page renders form', function () {
    $response = $this->get(route('job-offers.create'));

    $response->assertOk();
    $response->assertSee('Create Job Offer');
});

test('store creates a new job offer', function () {
    $response = $this->post(route('job-offers.store'), [
        'title' => 'Senior Laravel Developer',
        'description' => 'We need an experienced Laravel developer.',
        'required_skills' => ['PHP', 'Laravel', 'MySQL'],
        'min_experience' => 3,
    ]);

    $response->assertRedirect(route('job-offers.index'));
    $this->assertDatabaseHas('job_offers', [
        'title' => 'Senior Laravel Developer',
        'user_id' => $this->user->id,
    ]);
});

test('store validates required fields', function () {
    $response = $this->post(route('job-offers.store'), []);

    $response->assertSessionHasErrors(['title', 'description', 'required_skills', 'min_experience']);
});

test('store validates min_experience is non-negative', function () {
    $response = $this->post(route('job-offers.store'), [
        'title' => 'Test',
        'description' => 'Test description',
        'required_skills' => ['PHP'],
        'min_experience' => -1,
    ]);

    $response->assertSessionHasErrors(['min_experience']);
});

test('show page displays job offer details', function () {
    $jobOffer = JobOffer::factory()->create(['user_id' => $this->user->id]);

    $response = $this->get(route('job-offers.show', $jobOffer));

    $response->assertOk();
    $response->assertSee($jobOffer->title);
    $response->assertSee($jobOffer->description);
});

test('show returns 403 for non-owner', function () {
    $other = User::factory()->create();
    $jobOffer = JobOffer::factory()->create(['user_id' => $other->id]);

    $response = $this->get(route('job-offers.show', $jobOffer));

    $response->assertForbidden();
});

test('edit page displays form with existing data', function () {
    $jobOffer = JobOffer::factory()->create(['user_id' => $this->user->id]);

    $response = $this->get(route('job-offers.edit', $jobOffer));

    $response->assertOk();
    $response->assertSee($jobOffer->title);
});

test('edit returns 403 for non-owner', function () {
    $other = User::factory()->create();
    $jobOffer = JobOffer::factory()->create(['user_id' => $other->id]);

    $response = $this->get(route('job-offers.edit', $jobOffer));

    $response->assertForbidden();
});

test('update modifies a job offer', function () {
    $jobOffer = JobOffer::factory()->create(['user_id' => $this->user->id]);

    $response = $this->put(route('job-offers.update', $jobOffer), [
        'title' => 'Updated Title',
        'description' => 'Updated description',
        'required_skills' => ['PHP', 'Laravel'],
        'min_experience' => 5,
    ]);

    $response->assertRedirect(route('job-offers.index'));
    $this->assertDatabaseHas('job_offers', [
        'id' => $jobOffer->id,
        'title' => 'Updated Title',
    ]);
});

test('update returns 403 for non-owner', function () {
    $other = User::factory()->create();
    $jobOffer = JobOffer::factory()->create(['user_id' => $other->id]);

    $response = $this->put(route('job-offers.update', $jobOffer), [
        'title' => 'Hacked',
        'description' => 'Hacked description',
        'required_skills' => ['PHP'],
        'min_experience' => 1,
    ]);

    $response->assertForbidden();
});

test('destroy deletes a job offer', function () {
    $jobOffer = JobOffer::factory()->create(['user_id' => $this->user->id]);

    $response = $this->delete(route('job-offers.destroy', $jobOffer));

    $response->assertRedirect(route('job-offers.index'));
    $this->assertDatabaseMissing('job_offers', ['id' => $jobOffer->id]);
});

test('destroy returns 403 for non-owner', function () {
    $other = User::factory()->create();
    $jobOffer = JobOffer::factory()->create(['user_id' => $other->id]);

    $response = $this->delete(route('job-offers.destroy', $jobOffer));

    $response->assertForbidden();
});

test('unauthenticated user is redirected to login', function () {
    auth()->logout();

    $response = $this->get(route('job-offers.index'));

    $response->assertRedirect(route('login'));
});
