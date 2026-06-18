<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $candidate->name }}
            </h2>
            <div class="flex gap-2">
                <form action="{{ route('job-offers.candidates.analyze', [$jobOffer, $candidate]) }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __('Run AI Analysis') }}
                    </button>
                </form>
                <a href="{{ route('job-offers.candidates.edit', [$jobOffer, $candidate]) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Edit') }}
                </a>
                <a href="{{ route('job-offers.candidates.index', $jobOffer) }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Back') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Email') }}</h3>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $candidate->email }}</p>
                    </div>

                    @if ($candidate->phone)
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Phone') }}</h3>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $candidate->phone }}</p>
                        </div>
                    @endif

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Job Offer') }}</h3>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">
                            <a href="{{ route('job-offers.show', $jobOffer) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                {{ $jobOffer->title }}
                            </a>
                        </p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('CV Text') }}</h3>
                        <div class="mt-1 p-4 bg-gray-50 dark:bg-gray-900 rounded-md">
                            <pre class="text-sm text-gray-900 dark:text-gray-100 whitespace-pre-wrap font-sans">{{ $candidate->cv_text }}</pre>
                        </div>
                    </div>

                    @php $analysis = $candidate->analyses->where('job_offer_id', $jobOffer->id)->first(); @endphp

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ __('AI Analysis') }}</h3>

                        @if ($analysis && $analysis->matching_score > 0)
                            <div class="space-y-4">
                                <div class="flex items-center gap-4">
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Matching Score') }}:</span>
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold @if($analysis->matching_score >= 80) bg-green-100 text-green-800 @elseif($analysis->matching_score >= 50) bg-yellow-100 text-yellow-800 @else bg-red-100 text-red-800 @endif">
                                        {{ $analysis->matching_score }}/100
                                    </span>
                                </div>

                                <div class="flex items-center gap-4">
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Recommendation') }}:</span>
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold @if($analysis->recommendation === 'Strongly Recommend' || $analysis->recommendation === 'Recommend') bg-green-100 text-green-800 @elseif($analysis->recommendation === 'Consider') bg-yellow-100 text-yellow-800 @else bg-red-100 text-red-800 @endif">
                                        {{ $analysis->recommendation }}
                                    </span>
                                </div>

                                @if ($analysis->structured_data)
                                    @foreach (['matched_skills' => 'Matched Skills', 'missing_skills' => 'Missing Skills', 'strengths' => 'Strengths', 'weaknesses' => 'Weaknesses'] as $key => $label)
                                        @if (isset($analysis->structured_data[$key]) && count($analysis->structured_data[$key]))
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __($label) }}</h4>
                                                <div class="mt-1 flex flex-wrap gap-2">
                                                    @foreach ($analysis->structured_data[$key] as $item)
                                                        <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded text-sm text-gray-800 dark:text-gray-200">{{ $item }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

                                    @if (isset($analysis->structured_data['summary']))
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Summary') }}</h4>
                                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $analysis->structured_data['summary'] }}</p>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        @elseif ($analysis && isset($analysis->raw_ai_response['error']))
                            <p class="text-red-600 dark:text-red-400">{{ __('Analysis failed. Please try again.') }}</p>
                        @else
                            <p class="text-gray-500 dark:text-gray-400">{{ __('No analysis yet. Click "Run AI Analysis" to start one.') }}</p>
                        @endif
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Conversations') }}</h3>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $candidate->conversations->count() }} conversations</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
