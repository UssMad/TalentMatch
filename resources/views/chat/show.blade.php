<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $conversationModel->title }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('job-offers.candidates.chat.index', [$jobOffer, $candidate]) }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('All Chats') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-4 max-h-[60vh] overflow-y-auto" id="message-container">
                    @forelse ($messages as $message)
                        @if ($message['role'] === 'user')
                            <div class="flex justify-end">
                                <div class="max-w-[75%] bg-indigo-600 text-white rounded-lg px-4 py-2">
                                    <p class="text-sm">{{ $message['content'] }}</p>
                                    <p class="text-xs text-indigo-200 mt-1">{{ \Carbon\Carbon::parse($message['created_at'])->diffForHumans() }}</p>
                                </div>
                            </div>
                        @else
                            <div class="flex justify-start">
                                <div class="max-w-[75%] bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg px-4 py-2">
                                    <p class="text-sm whitespace-pre-wrap">{{ $message['content'] }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ \Carbon\Carbon::parse($message['created_at'])->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                            {{ __('No messages yet. Start the conversation!') }}
                        </div>
                    @endforelse
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700 p-4">
                    <form method="POST" action="{{ route('job-offers.candidates.chat.store', [$jobOffer, $candidate]) }}" class="flex gap-3">
                        @csrf
                        <input type="hidden" name="conversation_id" value="{{ $conversationModel->id }}">
                        <textarea
                            name="message"
                            rows="2"
                            class="flex-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            placeholder="{{ __('Ask about this candidate...') }}"
                            required
                        ></textarea>
                        <x-primary-button>{{ __('Send') }}</x-primary-button>
                    </form>
                    <x-input-error class="mt-2" :messages="$errors->get('message')" />
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
