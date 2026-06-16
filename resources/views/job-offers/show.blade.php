<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $jobOffer->title }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('job-offers.edit', $jobOffer) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Edit') }}
                </a>
                <a href="{{ route('job-offers.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
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
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Description') }}</h3>
                        <p class="mt-1 text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $jobOffer->description }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Required Skills') }}</h3>
                        <div class="mt-1 flex flex-wrap gap-2">
                            @foreach ($jobOffer->required_skills as $skill)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                    {{ $skill }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Minimum Experience') }}</h3>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $jobOffer->min_experience }} years</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Candidates') }}</h3>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">
                            <a href="{{ route('job-offers.candidates.index', $jobOffer) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                {{ $jobOffer->candidates->count() }} candidates
                            </a>
                        </p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Analyses') }}</h3>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $jobOffer->analyses->count() }} analyses</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
