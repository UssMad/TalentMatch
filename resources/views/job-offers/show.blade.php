<x-app-layout>
    @section('title', $jobOffer->title)

    @php
        $candidates = $jobOffer->candidates;
        $convoquerCount = 0;
        $attenteCount = 0;
        $rejeterCount = 0;

        foreach ($candidates as $cand) {
            $analysis = $cand->analyses->where('job_offer_id', $jobOffer->id)->first();
            if ($analysis && $analysis->matching_score > 0) {
                $rec = $analysis->recommendation instanceof \App\Enums\Recommendation
                    ? $analysis->recommendation->value
                    : $analysis->recommendation;
                match ($rec) {
                    'convoquer' => $convoquerCount++,
                    'attente' => $attenteCount++,
                    'rejeter' => $rejeterCount++,
                    default => null,
                };
            }
        }

        $sortedCandidates = $candidates->sortByDesc(function ($cand) use ($jobOffer) {
            $analysis = $cand->analyses->where('job_offer_id', $jobOffer->id)->first();
            return $analysis ? $analysis->matching_score : -1;
        });
    @endphp

    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex items-center justify-between">
            <h1 class="text-xl text-gray-900 dark:text-gray-100">{{ $jobOffer->title }}</h1>
            <div class="flex gap-2">
                <a href="{{ route('job-offers.edit', $jobOffer) }}" class="btn-outline">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Modifier
                </a>
                <a href="{{ route('job-offers.index') }}" class="btn-outline">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Retour
                </a>
            </div>
        </div>

        {{-- Two-column layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
            {{-- Left: Offer details --}}
            <div class="lg:col-span-3 card space-y-5">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Description</h3>
                    <p class="text-sm text-gray-900 dark:text-gray-100 whitespace-pre-wrap leading-relaxed">{{ $jobOffer->description }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Compétences requises</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($jobOffer->required_skills as $skill)
                            <x-skill-tag :skill="$skill" />
                        @endforeach
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                    <span class="badge-gray text-sm">Expérience min : {{ $jobOffer->min_experience }} an{{ $jobOffer->min_experience > 1 ? 's' : '' }}</span>
                </div>
            </div>

            {{-- Right: Stat cards --}}
            <div class="lg:col-span-2 space-y-3">
                <div class="card-accent-green">
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">À convoquer</p>
                    <p class="text-2xl font-medium text-gray-900 dark:text-gray-100">{{ $convoquerCount }}</p>
                </div>
                <div class="card-accent-amber">
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">En attente</p>
                    <p class="text-2xl font-medium text-gray-900 dark:text-gray-100">{{ $attenteCount }}</p>
                </div>
                <div class="card-accent-red">
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">À rejeter</p>
                    <p class="text-2xl font-medium text-gray-900 dark:text-gray-100">{{ $rejeterCount }}</p>
                </div>
            </div>
        </div>

        {{-- Candidates table --}}
        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-medium text-gray-900 dark:text-gray-100">Candidats</h3>
                <a href="{{ route('job-offers.candidates.create', $jobOffer) }}" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Ajouter un candidat
                </a>
            </div>

            @if ($sortedCandidates->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-100 dark:border-gray-700">
                                <th class="text-start py-3 pr-2 font-medium text-gray-500 dark:text-gray-400">Candidat</th>
                                <th class="text-center py-3 px-2 font-medium text-gray-500 dark:text-gray-400">Score</th>
                                <th class="text-center py-3 px-2 font-medium text-gray-500 dark:text-gray-400">Recommandation</th>
                                <th class="text-center py-3 px-2 font-medium text-gray-500 dark:text-gray-400">Expérience</th>
                                <th class="text-end py-3 pl-2 font-medium text-gray-500 dark:text-gray-400">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sortedCandidates as $candidate)
                                @php $analysis = $candidate->analyses->where('job_offer_id', $jobOffer->id)->first(); @endphp
                                <tr class="border-b border-gray-50 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-colors">
                                    <td class="py-3 pr-2">
                                        <a href="{{ route('job-offers.candidates.show', [$jobOffer, $candidate]) }}" class="font-medium text-gray-900 dark:text-gray-100 hover:text-brand-600 dark:hover:text-brand-400">
                                            {{ $candidate->name }}
                                        </a>
                                        <p class="text-xs text-gray-400 dark:text-gray-500">{{ $candidate->email }}</p>
                                    </td>
                                    <td class="py-3 px-2 text-center">
                                        @if ($analysis && $analysis->matching_score > 0)
                                            <x-score-badge :score="$analysis->matching_score" />
                                        @else
                                            <span class="text-xs text-gray-400 dark:text-gray-500">—</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-2 text-center">
                                        @if ($analysis && $analysis->matching_score > 0)
                                            <x-recommendation-badge :recommendation="$analysis->recommendation" />
                                        @else
                                            <span class="text-xs text-gray-400 dark:text-gray-500">—</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-2 text-center text-sm text-gray-600 dark:text-gray-400">
                                        {{ $candidate->analyses->where('job_offer_id', $jobOffer->id)->first()?->structured_data['annees_experience'] ?? '—' }}
                                    </td>
                                    <td class="py-3 pl-2 text-end">
                                        <div class="flex items-center justify-end gap-2">
                                            @if (!$analysis || !$analysis->matching_score)
                                                <form action="{{ route('job-offers.candidates.analyze', [$jobOffer, $candidate]) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-xs font-medium text-brand-600 dark:text-brand-400 hover:text-brand-700 dark:hover:text-brand-300 transition-colors">
                                                        Analyse
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('job-offers.candidates.chat.index', [$jobOffer, $candidate]) }}" class="text-xs font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">
                                                Discuter ↗
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <x-empty-state
                    icon="users"
                    title="Aucun candidat"
                    message="Ajoutez un candidat à cette offre pour lancer l'analyse IA."
                    :actionUrl="route('job-offers.candidates.create', $jobOffer)"
                    actionLabel="Ajouter un candidat"
                />
            @endif
        </div>
    </div>
</x-app-layout>
