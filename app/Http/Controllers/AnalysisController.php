<?php

namespace App\Http\Controllers;

use App\Jobs\RunAnalysisJob;
use App\Models\Candidate;
use App\Models\JobOffer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class AnalysisController extends Controller
{
    public function trigger(JobOffer $jobOffer, Candidate $candidate): RedirectResponse
    {
        Gate::authorize('modify', $jobOffer);

        RunAnalysisJob::dispatch($candidate->id, $jobOffer->id);

        return redirect()->route('job-offers.candidates.show', [$jobOffer, $candidate])
            ->with('status', 'Analysis has been queued and will be processed shortly.');
    }
}
