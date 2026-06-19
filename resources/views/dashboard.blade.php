<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            @if (session('status'))
                <div class="p-4 bg-success-50 dark:bg-success-900 border border-success-200 dark:border-success-700 rounded-lg text-success-700 dark:text-success-300">
                    {{ session('status') }}
                </div>
            @endif

            {{-- KPI Stat Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="stat-card">
                    <div class="flex items-center gap-4">
                        <div class="p-3 rounded-lg bg-brand-100 dark:bg-brand-900/50 text-brand-600 dark:text-brand-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Job Offers') }}</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalJobOffers }}</p>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="flex items-center gap-4">
                        <div class="p-3 rounded-lg bg-success-100 dark:bg-success-900/50 text-success-600 dark:text-success-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Candidates') }}</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalCandidates }}</p>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="flex items-center gap-4">
                        <div class="p-3 rounded-lg bg-warning-100 dark:bg-warning-900/50 text-warning-600 dark:text-warning-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Analyses') }}</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalAnalyses }}</p>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="flex items-center gap-4">
                        <div class="p-3 rounded-lg bg-brand-100 dark:bg-brand-900/50 text-brand-600 dark:text-brand-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Avg Match') }}</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $avgMatchScore ? number_format($avgMatchScore, 0) : '--' }}<span class="text-lg">%</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Activity & Quick Actions --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Recent Activity --}}
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ __('Recent Analyses') }}</h3>

                        @if ($recentAnalyses->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <th class="text-start py-3 px-2 font-medium text-gray-500 dark:text-gray-400">{{ __('Candidate') }}</th>
                                            <th class="text-start py-3 px-2 font-medium text-gray-500 dark:text-gray-400">{{ __('Job Offer') }}</th>
                                            <th class="text-center py-3 px-2 font-medium text-gray-500 dark:text-gray-400">{{ __('Score') }}</th>
                                            <th class="text-center py-3 px-2 font-medium text-gray-500 dark:text-gray-400">{{ __('Recommendation') }}</th>
                                            <th class="text-end py-3 px-2 font-medium text-gray-500 dark:text-gray-400">{{ __('Date') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentAnalyses as $analysis)
                                            <tr class="border-b border-gray-100 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                                <td class="py-3 px-2 text-gray-900 dark:text-gray-100">
                                                    @if ($analysis->candidate)
                                                        <a href="{{ route('job-offers.candidates.show', [$analysis->jobOffer, $analysis->candidate]) }}" class="hover:text-brand-600 dark:hover:text-brand-400">
                                                            {{ $analysis->candidate->name }}
                                                        </a>
                                                    @else
                                                        <span class="text-gray-400">{{ __('Deleted') }}</span>
                                                    @endif
                                                </td>
                                                <td class="py-3 px-2 text-gray-700 dark:text-gray-300">
                                                    @if ($analysis->jobOffer)
                                                        <a href="{{ route('job-offers.show', $analysis->jobOffer) }}" class="hover:text-brand-600 dark:hover:text-brand-400">
                                                            {{ $analysis->jobOffer->title }}
                                                        </a>
                                                    @else
                                                        <span class="text-gray-400">{{ __('Deleted') }}</span>
                                                    @endif
                                                </td>
                                                <td class="py-3 px-2 text-center">
                                                    @php
                                                        $scoreClass = $analysis->matching_score >= 80 ? 'badge-green' : ($analysis->matching_score >= 50 ? 'badge-yellow' : 'badge-red');
                                                    @endphp
                                                    <span class="{{ $scoreClass }}">{{ $analysis->matching_score }}/100</span>
                                                </td>
                                                <td class="py-3 px-2 text-center">
                                                    @php
                                                        $recValue = $analysis->recommendation?->value ?? $analysis->recommendation; $recClass = $recValue === 'convoquer' ? 'badge-green' : ($recValue === 'attente' ? 'badge-yellow' : 'badge-red');
                                                    @endphp
                                                    <span class="{{ $recClass }}">{{ $recValue }}</span>
                                                </td>
                                                <td class="py-3 px-2 text-end text-gray-500 dark:text-gray-400 text-xs">
                                                    {{ $analysis->created_at->diffForHumans() }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400">{{ __('No analyses yet.') }}</p>
                                <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">{{ __('Run an AI analysis on a candidate to see results here.') }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('Quick Actions') }}</h3>

                    <a href="{{ route('job-offers.create') }}" class="block stat-card hover:border-brand-300 dark:hover:border-brand-700 group">
                        <div class="flex items-center gap-4">
                            <div class="p-2 rounded-lg bg-brand-100 dark:bg-brand-900/50 text-brand-600 dark:text-brand-400 group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ __('Create Job Offer') }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Post a new position') }}</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('job-offers.index') }}" class="block stat-card hover:border-brand-300 dark:hover:border-brand-700 group">
                        <div class="flex items-center gap-4">
                            <div class="p-2 rounded-lg bg-success-100 dark:bg-success-900/50 text-success-600 dark:text-success-400 group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ __('View Candidates') }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Browse & manage applicants') }}</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('chat.global') }}" class="block stat-card hover:border-brand-300 dark:hover:border-brand-700 group">
                        <div class="flex items-center gap-4">
                            <div class="p-2 rounded-lg bg-warning-100 dark:bg-warning-900/50 text-warning-600 dark:text-warning-400 group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ __('AI Chat') }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Talk with the AI assistant') }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
