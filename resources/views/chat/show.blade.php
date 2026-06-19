<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-brand-100 dark:bg-brand-900/50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                </div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $conversationModel->title }}
                </h2>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('job-offers.candidates.chat.index', [$jobOffer, $candidate]) }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    {{ __('All Chats') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6 space-y-4 max-h-[65vh] overflow-y-auto" id="message-container">
                    @forelse ($messages as $message)
                        @if ($message['role'] === 'user')
                            <div class="flex justify-end">
                                <div class="max-w-[75%] bg-brand-600 text-white rounded-2xl rounded-br-sm px-4 py-3">
                                    <p class="text-sm">{{ $message['content'] }}</p>
                                    <p class="text-xs text-brand-200 mt-1.5">{{ \Carbon\Carbon::parse($message['created_at'])->diffForHumans() }}</p>
                                </div>
                            </div>
                        @else
                            <div class="flex justify-start">
                                <div class="max-w-[75%] bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-2xl rounded-bl-sm px-4 py-3">
                                    <p class="text-sm whitespace-pre-wrap leading-relaxed">{{ $message['content'] }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5">{{ \Carbon\Carbon::parse($message['created_at'])->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="text-center py-12">
                            <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400">{{ __('No messages yet. Start the conversation!') }}</p>
                        </div>
                    @endforelse
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-b-lg">
                    <form method="POST" action="{{ route('job-offers.candidates.chat.store', [$jobOffer, $candidate]) }}" class="flex gap-3 items-end">
                        @csrf
                        <input type="hidden" name="conversation_id" value="{{ $conversationModel->id }}">
                        <div class="flex-1">
                            <textarea
                                name="message"
                                rows="2"
                                class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-500 dark:focus:border-brand-600 focus:ring-brand-500 dark:focus:ring-brand-600 rounded-xl shadow-sm resize-none"
                                placeholder="{{ __('Ask about this candidate...') }}"
                                required
                            ></textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('message')" />
                        </div>
                        <x-primary-button class="mb-0.5 rounded-xl px-5">
                            <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            {{ __('Send') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const container = document.getElementById('message-container');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        </script>
    @endpush
</x-app-layout>
