<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-brand-100 dark:bg-brand-900/50 flex items-center justify-center">
                    <span class="text-brand-700 dark:text-brand-300 font-semibold">{{ substr($candidate->name, 0, 2) }}</span>
                </div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $candidate->name }}
                </h2>
            </div>
            <div class="flex gap-2">
                <form action="{{ route('job-offers.candidates.analyze', [$jobOffer, $candidate]) }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-brand-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        {{ __('Run AI Analysis') }}
                    </button>
                </form>
                <a href="{{ route('job-offers.candidates.chat.index', [$jobOffer, $candidate]) }}" class="inline-flex items-center px-4 py-2 bg-success-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-success-700 focus:outline-none focus:ring-2 focus:ring-success-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                    {{ __('Chat') }}
                </a>
                <a href="{{ route('job-offers.candidates.edit', [$jobOffer, $candidate]) }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    {{ __('Edit') }}
                </a>
                <a href="{{ route('job-offers.candidates.index', $jobOffer) }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    {{ __('Back') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Email') }}</h3>
                            <p class="mt-1 text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                {{ $candidate->email }}
                            </p>
                        </div>

                        @if ($candidate->phone)
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Phone') }}</h3>
                                <p class="mt-1 text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    {{ $candidate->phone }}
                                </p>
                            </div>
                        @endif

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Job Offer') }}</h3>
                            <p class="mt-1">
                                <a href="{{ route('job-offers.show', $jobOffer) }}" class="inline-flex items-center gap-1 text-brand-600 dark:text-brand-400 hover:underline">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $jobOffer->title }}
                                </a>
                            </p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Conversations') }}</h3>
                            <p class="mt-1 text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                </svg>
                                {{ $candidate->conversations->count() }} {{ __('conversations') }}
                            </p>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ __('CV Text') }}</h3>
                        <div class="p-4 bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700">
                            <pre class="text-sm text-gray-900 dark:text-gray-100 whitespace-pre-wrap font-sans">{{ $candidate->cv_text }}</pre>
                        </div>
                    </div>

                    @php $analysis = $candidate->analyses->where('job_offer_id', $jobOffer->id)->first(); @endphp

                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            {{ __('AI Analysis') }}
                        </h3>

                        @if ($analysis && $analysis->matching_score > 0)
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6 space-y-5">
                                <div class="flex items-center gap-4">
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Matching Score') }}:</span>
                                    <span class="{{ $analysis->matching_score >= 80 ? 'badge-green' : ($analysis->matching_score >= 50 ? 'badge-yellow' : 'badge-red') }} text-sm px-3 py-1">
                                        {{ $analysis->matching_score }}/100
                                    </span>
                                </div>

                                <div class="flex items-center gap-4">
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Recommendation') }}:</span>
                                    <span class="{{ $analysis->recommendation?->value === 'convoquer' ? 'badge-green' : ($analysis->recommendation?->value === 'attente' ? 'badge-yellow' : 'badge-red') }} text-sm px-3 py-1">
                                        {{ $analysis->recommendation?->value ?? $analysis->recommendation }}
                                    </span>
                                </div>

                                @if ($analysis->structured_data)
                                    @foreach (['extracted_skills' => 'Matched Skills', 'missing_skills' => 'Missing Skills', 'strengths' => 'Strengths', 'weaknesses' => 'Weaknesses'] as $key => $label)
                                        @if (isset($analysis->structured_data[$key]) && count($analysis->structured_data[$key]))
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ __($label) }}</h4>
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach ($analysis->structured_data[$key] as $item)
                                                        <span class="px-2.5 py-1 bg-white dark:bg-gray-800 rounded-lg text-sm text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-700">
                                                            {{ $item }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

                                    @if (isset($analysis->structured_data['justification']))
                                        <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">{{ __('Justification') }}</h4>
                                            <p class="text-gray-900 dark:text-gray-100 leading-relaxed">{{ $analysis->structured_data['justification'] }}</p>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        @elseif ($analysis && isset($analysis->raw_ai_response['error']))
                            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                                <p class="text-red-600 dark:text-red-400 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ __('Analysis failed. Please try again.') }}
                                </p>
                            </div>
                        @else
                            <div class="text-center py-8 bg-gray-50 dark:bg-gray-900 rounded-lg border border-dashed border-gray-300 dark:border-gray-600">
                                <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400">{{ __('No analysis yet.') }}</p>
                                <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">{{ __('Click "Run AI Analysis" to start one.') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
