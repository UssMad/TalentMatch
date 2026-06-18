<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCandidateRequest;
use App\Http\Requests\UpdateCandidateRequest;
use App\Models\Candidate;
use App\Models\JobOffer;
use App\Services\CandidateService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CandidateController extends Controller
{
    public function __construct(
        private readonly CandidateService $candidateService,
    ) {}

    public function index(JobOffer $jobOffer): View
    {
        $this->authorize('viewAny', [Candidate::class, $jobOffer]);

        $candidates = $this->candidateService->list($jobOffer);

        return view('candidates.index', compact('jobOffer', 'candidates'));
    }

    public function create(JobOffer $jobOffer): View
    {
        $this->authorize('create', [Candidate::class, $jobOffer]);

        return view('candidates.create', compact('jobOffer'));
    }

    public function store(StoreCandidateRequest $request, JobOffer $jobOffer): RedirectResponse
    {
        $this->authorize('create', [Candidate::class, $jobOffer]);

        $data = array_merge($request->validated(), [
            'job_offer_id' => $jobOffer->id,
        ]);

        $this->candidateService->create($data);

        return redirect()->route('job-offers.candidates.index', $jobOffer)
            ->with('status', 'Candidate created successfully.');
    }

    public function show(JobOffer $jobOffer, Candidate $candidate): View
    {
        $this->authorize('view', $candidate);

        $candidate = $this->candidateService->find($candidate);

        return view('candidates.show', compact('jobOffer', 'candidate'));
    }

    public function edit(JobOffer $jobOffer, Candidate $candidate): View
    {
        $this->authorize('update', $candidate);

        return view('candidates.edit', compact('jobOffer', 'candidate'));
    }

    public function update(UpdateCandidateRequest $request, JobOffer $jobOffer, Candidate $candidate): RedirectResponse
    {
        $this->authorize('update', $candidate);

        $this->candidateService->update($candidate, $request->validated());

        return redirect()->route('job-offers.candidates.index', $jobOffer)
            ->with('status', 'Candidate updated successfully.');
    }

    public function destroy(JobOffer $jobOffer, Candidate $candidate): RedirectResponse
    {
        $this->authorize('delete', $candidate);

        $this->candidateService->delete($candidate);

        return redirect()->route('job-offers.candidates.index', $jobOffer)
            ->with('status', 'Candidate deleted successfully.');
    }
}
