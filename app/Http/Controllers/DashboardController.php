<?php

namespace App\Http\Controllers;

use App\Models\Analysis;
use App\Models\Candidate;
use App\Models\JobOffer;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalJobOffers = JobOffer::where('user_id', $user->id)->count();

        $jobOfferIds = JobOffer::where('user_id', $user->id)->pluck('id');

        $totalCandidates = Candidate::whereIn('job_offer_id', $jobOfferIds)->count();

        $totalAnalyses = Analysis::whereIn('job_offer_id', $jobOfferIds)->where('matching_score', '>', 0)->count();

        $avgMatchScore = Analysis::whereIn('job_offer_id', $jobOfferIds)
            ->where('matching_score', '>', 0)
            ->avg('matching_score');

        $recentAnalyses = Analysis::whereIn('job_offer_id', $jobOfferIds)
            ->where('matching_score', '>', 0)
            ->with(['candidate', 'jobOffer'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalJobOffers',
            'totalCandidates',
            'totalAnalyses',
            'avgMatchScore',
            'recentAnalyses',
        ));
    }
}
