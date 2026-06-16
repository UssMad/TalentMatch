<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobOfferRequest;
use App\Http\Requests\UpdateJobOfferRequest;
use App\Models\JobOffer;
use App\Services\JobOfferService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class JobOfferController extends Controller
{
    public function __construct(
        private readonly JobOfferService $jobOfferService,
    ) {}

    public function index(Request $request): View
    {
        $jobOffers = $this->jobOfferService->list($request->user());

        return view('job-offers.index', compact('jobOffers'));
    }

    public function create(): View
    {
        return view('job-offers.create');
    }

    public function store(StoreJobOfferRequest $request): RedirectResponse
    {
        $data = array_merge($request->validated(), [
            'user_id' => $request->user()->id,
        ]);

        $this->jobOfferService->create($data);

        return redirect()->route('job-offers.index')
            ->with('status', 'Job offer created successfully.');
    }

    public function show(JobOffer $jobOffer): View
    {
        $this->authorizeOwner($jobOffer);

        $jobOffer = $this->jobOfferService->find($jobOffer);

        return view('job-offers.show', compact('jobOffer'));
    }

    public function edit(JobOffer $jobOffer): View
    {
        $this->authorizeOwner($jobOffer);

        return view('job-offers.edit', compact('jobOffer'));
    }

    public function update(UpdateJobOfferRequest $request, JobOffer $jobOffer): RedirectResponse
    {
        $this->authorizeOwner($jobOffer);

        $this->jobOfferService->update($jobOffer, $request->validated());

        return redirect()->route('job-offers.index')
            ->with('status', 'Job offer updated successfully.');
    }

    public function destroy(JobOffer $jobOffer): RedirectResponse
    {
        $this->authorizeOwner($jobOffer);

        $this->jobOfferService->delete($jobOffer);

        return redirect()->route('job-offers.index')
            ->with('status', 'Job offer deleted successfully.');
    }

    private function authorizeOwner(JobOffer $jobOffer): void
    {
        Gate::authorize('modify', $jobOffer);
    }
}
