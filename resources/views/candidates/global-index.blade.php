<x-app-layout>
    @section('title', 'Candidats')

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-xl text-gray-900 dark:text-gray-100">Candidats</h1>
            @if ($jobOffers->count() > 0)
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        Ajouter un candidat
                        <svg class="w-4 h-4" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-72 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-lg py-1 z-20">
                        <p class="px-4 py-2 text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider">Choisir une offre</p>
                        @foreach ($jobOffers as $offer)
                            <a href="{{ route('job-offers.candidates.create', $offer) }}"
                               class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-brand-50 dark:hover:bg-gray-700/50 hover:text-brand-700 dark:hover:text-brand-300 transition-colors">
                                {{ $offer->title }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        @if ($candidates->count() > 0)
            <div class="card p-0">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-100 dark:border-gray-700">
                                <th class="text-start py-3.5 px-5 font-medium text-gray-500 dark:text-gray-400">Candidat</th>
                                <th class="text-start py-3.5 px-4 font-medium text-gray-500 dark:text-gray-400">Offre</th>
                                <th class="text-center py-3.5 px-4 font-medium text-gray-500 dark:text-gray-400">Score</th>
                                <th class="text-center py-3.5 px-4 font-medium text-gray-500 dark:text-gray-400">Recommandation</th>
                                <th class="text-end py-3.5 px-5 font-medium text-gray-500 dark:text-gray-400">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($candidates as $candidate)
                                @php
                                    $analysis = $candidate->analyses->where('job_offer_id', $candidate->job_offer_id)->first();
                                @endphp
                                <tr class="border-b border-gray-50 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-colors">
                                    <td class="py-3.5 px-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-brand-50 dark:bg-brand-900/20 flex items-center justify-center shrink-0">
                                                <span class="text-xs font-medium text-brand-700 dark:text-brand-300">{{ substr($candidate->name, 0, 2) }}</span>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $candidate->name }}</p>
                                                <p class="text-xs text-gray-400 dark:text-gray-500">{{ $candidate->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4 text-gray-600 dark:text-gray-400">
                                        @if ($candidate->jobOffer)
                                            <a href="{{ route('job-offers.show', $candidate->jobOffer) }}" class="hover:text-brand-600 dark:hover:text-brand-400">
                                                {{ $candidate->jobOffer->title }}
                                            </a>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        @if ($analysis && $analysis->matching_score > 0)
                                            <x-score-badge :score="$analysis->matching_score" />
                                        @else
                                            <span class="text-xs text-gray-400 dark:text-gray-500">—</span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        @if ($analysis && $analysis->matching_score > 0)
                                            <x-recommendation-badge :recommendation="$analysis->recommendation" />
                                        @else
                                            <span class="text-xs text-gray-400 dark:text-gray-500">—</span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-5 text-end">
                                        <div class="flex items-center justify-end gap-2">
                                            @if ($candidate->jobOffer)
                                                <a href="{{ route('job-offers.candidates.show', [$candidate->jobOffer, $candidate]) }}"
                                                   class="text-xs font-medium text-brand-600 dark:text-brand-400 hover:text-brand-700 dark:hover:text-brand-300 transition-colors">
                                                    Voir
                                                </a>
                                                <a href="{{ route('job-offers.candidates.chat.index', [$candidate->jobOffer, $candidate]) }}"
                                                   class="text-xs font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">
                                                    Discuter ↗
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($candidates->hasPages())
                <div class="mt-4">
                    {{ $candidates->links() }}
                </div>
            @endif
        @else
            <x-empty-state
                icon="users"
                title="Aucun candidat"
                message="Ajoutez un candidat à une offre pour voir son profil ici."
                :actionUrl="route('job-offers.index')"
                actionLabel="Voir les offres"
            />
        @endif
    </div>
</x-app-layout>
