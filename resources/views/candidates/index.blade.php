<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Candidates for') }}: {{ $jobOffer->title }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('job-offers.candidates.create', $jobOffer) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    {{ __('Add Candidate') }}
                </a>
                <a href="{{ route('job-offers.show', $jobOffer) }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Back to Offer') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 p-4 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-md text-green-700 dark:text-green-300">
                    {{ session('status') }}
                </div>
            @endif

            @forelse ($candidates as $candidate)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="p-6 flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                <a href="{{ route('job-offers.candidates.show', [$jobOffer, $candidate]) }}" class="hover:underline">
                                    {{ $candidate->name }}
                                </a>
                            </h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ $candidate->email }}
                                @if ($candidate->phone)
                                    &middot; {{ $candidate->phone }}
                                @endif
                            </p>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                {{ Str::limit($candidate->cv_text, 150) }}
                            </p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('job-offers.candidates.edit', [$jobOffer, $candidate]) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Edit') }}
                            </a>
                            <form method="POST" action="{{ route('job-offers.candidates.destroy', [$jobOffer, $candidate]) }}" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Delete') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                        {{ __('No candidates yet for this job offer.') }}
                        <a href="{{ route('job-offers.candidates.create', $jobOffer) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                            {{ __('Add your first candidate.') }}
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
