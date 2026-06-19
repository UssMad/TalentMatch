<x-app-layout>
    @section('title', 'Mes offres')

    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex items-center justify-between">
            <h1 class="text-xl text-gray-900 dark:text-gray-100">Mes offres</h1>
            <a href="{{ route('job-offers.create') }}" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Nouvelle offre
            </a>
        </div>

        {{-- Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse ($jobOffers as $jobOffer)
                <div class="card hover:border-brand-200 dark:hover:border-brand-700 transition-colors group">
                    <div class="flex flex-col h-full">
                        {{-- Title --}}
                        <h2 class="font-medium text-gray-900 dark:text-gray-100 mb-1">
                            <a href="{{ route('job-offers.show', $jobOffer) }}" class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors">
                                {{ $jobOffer->title }}
                            </a>
                        </h2>

                        {{-- Description excerpt --}}
                        <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 mb-3">
                            {{ Str::limit($jobOffer->description, 200) }}
                        </p>

                        {{-- Skill tags --}}
                        @if ($jobOffer->required_skills)
                            @php
                                $skills = is_array($jobOffer->required_skills) ? $jobOffer->required_skills : [];
                                $shown = array_slice($skills, 0, 4);
                                $remaining = count($skills) - 4;
                            @endphp
                            <div class="flex flex-wrap gap-1.5 mb-4">
                                @foreach ($shown as $skill)
                                    <x-skill-tag :skill="$skill" max="15" />
                                @endforeach
                                @if ($remaining > 0)
                                    <span class="badge-gray">+{{ $remaining }} autre{{ $remaining > 1 ? 's' : '' }}</span>
                                @endif
                            </div>
                        @endif

                        {{-- Footer --}}
                        <div class="mt-auto pt-4 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $jobOffer->candidates_count ?? $jobOffer->candidates->count() }} candidat{{ ($jobOffer->candidates_count ?? $jobOffer->candidates->count()) > 1 ? 's' : '' }} analysé{{ ($jobOffer->candidates_count ?? $jobOffer->candidates->count()) > 1 ? 's' : '' }}
                            </span>
                            <a href="{{ route('job-offers.candidates.index', $jobOffer) }}" class="text-sm font-medium text-brand-600 dark:text-brand-400 hover:text-brand-700 dark:hover:text-brand-300 transition-colors">
                                Voir les candidats →
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="md:col-span-2">
                    <x-empty-state
                        icon="briefcase"
                        title="Aucune offre"
                        message="Créez votre première offre d'emploi pour commencer à recruter."
                        :actionUrl="route('job-offers.create')"
                        actionLabel="Créer une offre"
                    />
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
