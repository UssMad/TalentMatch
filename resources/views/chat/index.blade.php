<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Chats about') }}: {{ $candidate->name }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('job-offers.candidates.chat.store', [$jobOffer, $candidate]) }}"
                   onclick="event.preventDefault(); document.getElementById('start-chat-form').submit();"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('New Chat') }}
                </a>
                <form id="start-chat-form" method="POST" action="{{ route('job-offers.candidates.chat.store', [$jobOffer, $candidate]) }}" class="hidden">
                    @csrf
                    <input type="hidden" name="message" value="Hello! I would like to discuss this candidate.">
                </form>
                <a href="{{ route('job-offers.candidates.show', [$jobOffer, $candidate]) }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Back to Candidate') }}
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

            @forelse ($conversations as $conversation)
                <a href="{{ route('job-offers.candidates.chat.show', [$jobOffer, $candidate, $conversation->id]) }}" class="block mb-4">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <div class="p-6 flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $conversation->title }}
                                </h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $conversation->updated_at->diffForHumans() }}
                                </p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>
            @empty
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                        {{ __('No conversations yet for this candidate.') }}
                        <button onclick="event.preventDefault(); document.getElementById('start-chat-form').submit();" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                            {{ __('Start a new chat.') }}
                        </button>
                    </div>
                </div>
            @endforelse

            @if ($conversations->hasPages())
                <div class="mt-6">
                    {{ $conversations->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
