<x-app-layout>
    @section('title', 'Tableau de bord')

    <div class="space-y-6">
        {{-- KPI cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="card">
                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-xl bg-brand-50 dark:bg-brand-900/20 text-brand-600 dark:text-brand-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Offres</p>
                        <p class="text-2xl font-medium text-gray-900 dark:text-gray-100">{{ intval($totalJobOffers) }}</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-xl bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Candidats</p>
                        <p class="text-2xl font-medium text-gray-900 dark:text-gray-100">{{ intval($totalCandidates) }}</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-xl bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Analyses</p>
                        <p class="text-2xl font-medium text-gray-900 dark:text-gray-100">{{ intval($totalAnalyses) }}</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-xl bg-brand-50 dark:bg-brand-900/20 text-brand-600 dark:text-brand-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Score moyen</p>
                        <p class="text-2xl font-medium text-gray-900 dark:text-gray-100">
                            {{ $avgMatchScore ? number_format($avgMatchScore, 0) : '--' }}<span class="text-base text-gray-400 dark:text-gray-500">/100</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Activity & Quick Actions --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Recent Analyses --}}
            <div class="lg:col-span-2 card">
                <h3 class="text-base font-medium text-gray-900 dark:text-gray-100 mb-4">Analyses récentes</h3>

                @if ($recentAnalyses->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-100 dark:border-gray-700">
                                    <th class="text-start py-3 pr-2 font-medium text-gray-500 dark:text-gray-400">Candidat</th>
                                    <th class="text-start py-3 pr-2 font-medium text-gray-500 dark:text-gray-400">Offre</th>
                                    <th class="text-center py-3 px-2 font-medium text-gray-500 dark:text-gray-400">Score</th>
                                    <th class="text-center py-3 px-2 font-medium text-gray-500 dark:text-gray-400">Recommandation</th>
                                    <th class="text-end py-3 pl-2 font-medium text-gray-500 dark:text-gray-400">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentAnalyses as $analysis)
                                    <tr class="border-b border-gray-50 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-colors">
                                        <td class="py-3 pr-2 text-gray-900 dark:text-gray-100">
                                            @if ($analysis->candidate)
                                                <a href="{{ route('job-offers.candidates.show', [$analysis->jobOffer, $analysis->candidate]) }}" class="hover:text-brand-600 dark:hover:text-brand-400">
                                                    {{ $analysis->candidate->name }}
                                                </a>
                                            @endif
                                        </td>
                                        <td class="py-3 pr-2 text-gray-600 dark:text-gray-400">
                                            @if ($analysis->jobOffer)
                                                {{ $analysis->jobOffer->title }}
                                            @endif
                                        </td>
                                        <td class="py-3 px-2 text-center">
                                            <x-score-badge :score="$analysis->matching_score" />
                                        </td>
                                        <td class="py-3 px-2 text-center">
                                            <x-recommendation-badge :recommendation="$analysis->recommendation" />
                                        </td>
                                        <td class="py-3 pl-2 text-end text-xs text-gray-400 dark:text-gray-500">
                                            {{ $analysis->created_at->diffForHumans() }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <x-empty-state
                        icon="search"
                        title="Aucune analyse"
                        message="Lancez une analyse IA sur un candidat pour voir les résultats ici."
                    />
                @endif
            </div>

            {{-- Quick Actions --}}
            <div class="space-y-3">
                <h3 class="text-base font-medium text-gray-900 dark:text-gray-100">Actions rapides</h3>

                <a href="{{ route('job-offers.create') }}" class="card block hover:border-brand-200 dark:hover:border-brand-800 transition-colors group">
                    <div class="flex items-center gap-4">
                        <div class="p-2 rounded-xl bg-brand-50 dark:bg-brand-900/20 text-brand-600 dark:text-brand-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-gray-100 text-sm">Nouvelle offre</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Publier un poste</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('job-offers.index') }}" class="card block hover:border-brand-200 dark:hover:border-brand-800 transition-colors group">
                    <div class="flex items-center gap-4">
                        <div class="p-2 rounded-xl bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-gray-100 text-sm">Candidats</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Voir tous les profils</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('chat.global') }}" class="card block hover:border-brand-200 dark:hover:border-brand-800 transition-colors group">
                    <div class="flex items-center gap-4">
                        <div class="p-2 rounded-xl bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-gray-100 text-sm">Assistant IA</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Discuter avec l'IA</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
