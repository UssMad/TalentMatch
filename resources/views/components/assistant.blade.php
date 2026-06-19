@props(['candidate' => null, 'jobOffer' => null])

<div class="card-accent-indigo" x-data="assistantChat({{ $candidate ? $candidate->id : 'null' }})">
    {{-- Header --}}
    <div class="flex items-center gap-3 pb-4 border-b border-gray-100 dark:border-gray-700">
        <div class="w-9 h-9 rounded-lg bg-brand-100 dark:bg-brand-900/50 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
            </svg>
        </div>
        <div class="flex-1">
            <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100">Assistant IA</h3>
        </div>
        @if($candidate)
            <span class="badge-brand text-xs">{{ $candidate->name }}</span>
        @endif
    </div>

    {{-- Messages --}}
    <div class="max-h-72 overflow-y-auto space-y-3 py-4" x-ref="messagesContainer">
        <template x-for="(msg, i) in messages" :key="i">
            <div :class="msg.role === 'user' ? 'flex justify-end' : 'flex justify-start'">
                <div :class="msg.role === 'user'
                    ? 'bg-brand-50 dark:bg-brand-900/30 rounded-xl px-4 py-2.5 max-w-[80%]'
                    : 'bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-xl px-4 py-2.5 max-w-[80%]'">
                    <p class="text-sm text-gray-900 dark:text-gray-100 whitespace-pre-wrap leading-relaxed" x-text="msg.content"></p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1" x-text="msg.time"></p>
                </div>
            </div>
        </template>

        {{-- Loading indicator --}}
        <div x-show="loading" class="flex justify-start">
            <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-xl px-4 py-3">
                <div class="flex gap-1">
                    <span class="w-2 h-2 rounded-full bg-gray-300 dark:bg-gray-600 animate-bounce" style="animation-delay: 0ms"></span>
                    <span class="w-2 h-2 rounded-full bg-gray-300 dark:bg-gray-600 animate-bounce" style="animation-delay: 150ms"></span>
                    <span class="w-2 h-2 rounded-full bg-gray-300 dark:bg-gray-600 animate-bounce" style="animation-delay: 300ms"></span>
                </div>
            </div>
        </div>
    </div>

    {{-- Suggestion chips --}}
    <div x-show="messages.length === 0 && !loading" class="flex flex-wrap gap-2 pb-4">
        <button @click="sendSuggestion('Pourquoi ce score ?')" class="px-3 py-1.5 text-xs font-medium text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full hover:bg-brand-50 hover:border-brand-200 hover:text-brand-700 dark:hover:bg-brand-900/20 dark:hover:border-brand-800 dark:hover:text-brand-300 transition-colors">
            Pourquoi ce score ?
        </button>
        <button @click="sendSuggestion('Questions pour l\'entretien')" class="px-3 py-1.5 text-xs font-medium text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full hover:bg-brand-50 hover:border-brand-200 hover:text-brand-700 dark:hover:bg-brand-900/20 dark:hover:border-brand-800 dark:hover:text-brand-300 transition-colors">
            Questions pour l'entretien
        </button>
        <button @click="sendSuggestion('Comparer avec un autre candidat')" class="px-3 py-1.5 text-xs font-medium text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full hover:bg-brand-50 hover:border-brand-200 hover:text-brand-700 dark:hover:bg-brand-900/20 dark:hover:border-brand-800 dark:hover:text-brand-300 transition-colors">
            Comparer avec un autre candidat
        </button>
    </div>

    {{-- Input row --}}
    <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
        <form @submit.prevent="sendMessage()" class="flex gap-3">
            <input type="text"
                   x-model="input"
                   placeholder="Posez une question…"
                   class="block w-full border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-xl text-sm"
                   :disabled="loading"
            >
            <button type="submit"
                    class="btn-primary px-4"
                    :disabled="loading || !input.trim()">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('assistantChat', (candidateId) => ({
            messages: [],
            input: '',
            loading: false,

            init() {
                if (this.messages.length === 0) {
                    this.addMessage('assistant', 'Bonjour ! Je suis l\'assistant IA spécialisé dans l\'analyse de CV. Posez-moi des questions sur ce candidat, son adéquation avec l\'offre, ou demandez-moi de comparer des profils.');
                }
            },

            addMessage(role, content) {
                const now = new Date();
                const time = now.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
                this.messages.push({ role, content, time });
                this.$nextTick(() => {
                    const container = this.$refs.messagesContainer;
                    if (container) container.scrollTop = container.scrollHeight;
                });
            },

            async sendMessage() {
                const text = this.input.trim();
                if (!text || this.loading) return;

                this.addMessage('user', text);
                this.input = '';
                this.loading = true;

                try {
                    const response = await fetch('/assistant/chat', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            candidate_id: candidateId,
                            message: text,
                            history: this.messages.map(m => ({ role: m.role, content: m.content })),
                        }),
                    });

                    const data = await response.json();
                    this.addMessage('assistant', data.reply);
                } catch (e) {
                    this.addMessage('assistant', 'Désolé, je rencontre un problème technique. Veuillez réessayer.');
                } finally {
                    this.loading = false;
                }
            },

            sendSuggestion(text) {
                this.input = text;
                this.sendMessage();
            },
        }));
    });
</script>
@endpush
