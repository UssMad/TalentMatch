<x-app-layout>
    @section('title', $candidate->name)

    @php
        $analysis = $candidate->analyses->where('job_offer_id', $jobOffer->id)->first();
        $sd = $analysis ? $analysis->structured_data : [];
    @endphp

    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-brand-50 dark:bg-brand-900/20 flex items-center justify-center">
                    <span class="text-sm font-medium text-brand-700 dark:text-brand-300">{{ substr($candidate->name, 0, 2) }}</span>
                </div>
                <div>
                    <h1 class="text-xl text-gray-900 dark:text-gray-100">{{ $candidate->name }}</h1>
                    @if ($analysis && $analysis->matching_score > 0)
                        <div class="mt-1">
                            <x-recommendation-badge :recommendation="$analysis->recommendation" />
                        </div>
                    @endif
                </div>
            </div>
            <div class="flex gap-2">
                @if (!$analysis || !$analysis->matching_score)
                    <form action="{{ route('job-offers.candidates.analyze', [$jobOffer, $candidate]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            Lancer l'analyse
                        </button>
                    </form>
                @endif
                <a href="{{ route('job-offers.candidates.chat.index', [$jobOffer, $candidate]) }}" class="btn-success">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                    Discuter
                </a>
                <a href="{{ route('job-offers.candidates.edit', [$jobOffer, $candidate]) }}" class="btn-outline">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Modifier
                </a>
                <a href="{{ route('job-offers.candidates.index', $jobOffer) }}" class="btn-outline">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Retour
                </a>
            </div>
        </div>

        @if ($analysis && $analysis->matching_score > 0 && $sd)
            {{-- Score section --}}
            <div class="card flex items-center gap-6 py-6">
                <x-score-badge :score="$analysis->matching_score" size="lg" />
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Score de correspondance</p>
                    <p class="text-3xl font-medium text-gray-900 dark:text-gray-100">{{ intval($analysis->matching_score) }}<span class="text-lg text-gray-400 dark:text-gray-500">/100</span></p>
                </div>
            </div>

            {{-- Two-column grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Left column --}}
                <div class="space-y-4">
                    {{-- Points forts --}}
                    @if (count($sd['strengths'] ?? []))
                        <div class="card-accent-green">
                            <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Points forts
                            </h3>
                            <ul class="space-y-2">
                                @foreach ($sd['strengths'] as $strength)
                                    <li class="flex items-start gap-2 text-sm text-gray-700 dark:text-gray-300">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 mt-1.5 shrink-0"></span>
                                        {{ $strength }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Lacunes --}}
                    @if (count($sd['weaknesses'] ?? []))
                        <div class="card-accent-amber">
                            <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                                Lacunes
                            </h3>
                            <ul class="space-y-2">
                                @foreach ($sd['weaknesses'] as $weakness)
                                    <li class="flex items-start gap-2 text-sm text-gray-700 dark:text-gray-300">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mt-1.5 shrink-0"></span>
                                        {{ $weakness }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Compétences manquantes --}}
                    @if (count($sd['missing_skills'] ?? []))
                        <div class="card-accent-red">
                            <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Compétences manquantes
                            </h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($sd['missing_skills'] as $skill)
                                    <span class="badge-red">{{ $skill }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Right column --}}
                <div class="space-y-4">
                    {{-- Infos candidat --}}
                    <div class="card">
                        <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-3">Infos candidat</h3>
                        <div class="space-y-3">
                            <div class="flex items-center gap-3 text-sm">
                                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-gray-500 dark:text-gray-400 w-32 shrink-0">Expérience</span>
                                <span class="text-gray-900 dark:text-gray-100 font-medium">{{ $sd['years_of_experience'] ?? '—' }} an{{ ($sd['years_of_experience'] ?? 0) > 1 ? 's' : '' }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm">
                                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                </svg>
                                <span class="text-gray-500 dark:text-gray-400 w-32 shrink-0">Niveau d'études</span>
                                <span class="text-gray-900 dark:text-gray-100 font-medium">{{ $sd['education_level'] ?? '—' }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm">
                                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-gray-500 dark:text-gray-400 w-32 shrink-0">Langues</span>
                                <span class="text-gray-900 dark:text-gray-100 font-medium">{{ $sd['languages'] ? implode(', ', $sd['languages']) : '—' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Justification IA --}}
                    @if (($sd['justification'] ?? ''))
                        <div class="card bg-gray-50 dark:bg-gray-800/50">
                            <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Justification IA</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 italic leading-relaxed">{{ $sd['justification'] }}</p>
                        </div>
                    @endif

                    {{-- Compétences extraites --}}
                    @if (count($sd['extracted_skills'] ?? []))
                        <div class="card">
                            <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-3">Compétences extraites</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($sd['extracted_skills'] as $skill)
                                    <x-skill-tag :skill="$skill" />
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @elseif ($analysis && isset($analysis->raw_ai_response['error']))
            {{-- Error state --}}
            <div class="card-accent-red">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-red-800 dark:text-red-300">L'analyse a échoué</p>
                        <p class="text-sm text-red-600 dark:text-red-400 mt-1">Veuillez réessayer.</p>
                    </div>
                </div>
            </div>
        @else
            {{-- No analysis yet --}}
            <x-empty-state
                icon="search"
                title="Analyse non disponible"
                message="Lancez une analyse IA pour évaluer ce candidat."
            />
        @endif

        {{-- Assistant IA panel --}}
        <x-assistant :candidate="$candidate" :jobOffer="$jobOffer" />
    </div>
</x-app-layout>
