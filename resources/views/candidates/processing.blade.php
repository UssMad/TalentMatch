<x-app-layout>
    @section('title', 'Analyse en cours')

    <div class="max-w-lg mx-auto pt-12" x-data="analysisPoller()">
        <div class="card text-center py-12 space-y-6">
            {{-- Spinner --}}
            <div class="flex justify-center" x-show="status === 'processing'">
                <div class="w-12 h-12 rounded-full border-4 border-gray-100 dark:border-gray-700 border-t-brand-600 animate-spin"></div>
            </div>

            {{-- Completed icon --}}
            <div class="flex justify-center" x-show="status === 'completed'" x-cloak>
                <div class="w-12 h-12 rounded-full bg-green-50 dark:bg-green-900/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>

            {{-- Failed icon --}}
            <div class="flex justify-center" x-show="status === 'failed'" x-cloak>
                <div class="w-12 h-12 rounded-full bg-red-50 dark:bg-red-900/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>

            {{-- Status text --}}
            <div>
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100" x-show="status === 'processing'">
                    Analyse en cours…
                </h2>
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100" x-show="status === 'completed'" x-cloak>
                    Analyse terminée
                </h2>
                <h2 class="text-lg font-medium text-red-700 dark:text-red-400" x-show="status === 'failed'" x-cloak>
                    Analyse échouée
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                    L'IA analyse le CV de <strong>{{ $candidate->name }}</strong> contre l'offre <strong>{{ $jobOffer->title }}</strong>
                </p>
            </div>

            {{-- Retry button (on failure) --}}
            <div x-show="status === 'failed'" x-cloak>
                <form action="{{ route('job-offers.candidates.analyze', [$jobOffer, $candidate]) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Réessayer
                    </button>
                </form>
            </div>

            {{-- Estimated time --}}
            <p class="text-xs text-gray-400 dark:text-gray-500" x-show="status === 'processing'">
                L'analyse est effectuée en arrière-plan. Cette page se met à jour automatiquement.
            </p>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('analysisPoller', () => ({
                status: 'processing',

                init() {
                    this.poll();
                },

                async poll() {
                    const candidateId = {{ $candidate->id }};
                    const jobOfferId = {{ $jobOffer->id }};
                    const showUrl = '{{ route('job-offers.candidates.show', [$jobOffer, $candidate]) }}';

                    const check = async () => {
                        try {
                            const response = await fetch(`/candidates/${candidateId}/status?job_offer_id=${jobOfferId}`, {
                                headers: { 'Accept': 'application/json' },
                            });
                            const data = await response.json();

                            if (data.status === 'completed') {
                                this.status = 'completed';
                                window.location.href = showUrl;
                            } else if (data.status === 'failed') {
                                this.status = 'failed';
                            } else {
                                setTimeout(check, 3000);
                            }
                        } catch (e) {
                            setTimeout(check, 3000);
                        }
                    };

                    check();
                },
            }));
        });
    </script>
    @endpush
</x-app-layout>
