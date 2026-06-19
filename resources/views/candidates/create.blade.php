<x-app-layout>
    @section('title', 'Analyser un candidat')

    <div class="max-w-2xl mx-auto space-y-6">
        <h1 class="text-xl text-gray-900 dark:text-gray-100">Analyser un candidat</h1>

        <div class="card">
            <form method="POST" action="{{ route('job-offers.candidates.store', $jobOffer) }}" class="space-y-5"
                  x-data="{ submitting: false }"
                  @submit="submitting = true">
                @csrf

                {{-- Nom --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom du candidat</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}"
                           class="block w-full border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-xl text-sm"
                           placeholder="Jean Dupont" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}"
                           class="block w-full border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-xl text-sm"
                           placeholder="jean.dupont@email.com" required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Téléphone</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone') }}"
                           class="block w-full border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-xl text-sm"
                           placeholder="06 12 34 56 78">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- CV --}}
                <div>
                    <label for="cv_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Texte du CV</label>
                    <textarea id="cv_text" name="cv_text" rows="16"
                              class="block w-full border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-xl text-sm resize-y min-h-[16rem]"
                              placeholder="Copiez ici le contenu du CV (format texte)&#10;&#10;Exemple :&#10;Jean Dupont&#10;jean.dupont@email.com&#10;06 12 34 56 78&#10;&#10;EXPÉRIENCE PROFESSIONNELLE&#10;2020 - Présent | Lead Developer | TechCorp&#10;• Management d'équipe de 5 développeurs&#10;• Mise en place d'une architecture microservices&#10;&#10;2017 - 2020 | Développeur Full-stack | WebStudio&#10;• Développement d'applications Laravel et Vue.js&#10;• Migration d'une base MySQL vers PostgreSQL&#10;&#10;COMPÉTENCES&#10;Laravel, Vue.js, MySQL, Docker, AWS, Git, Agile/Scrum"
                              required>{{ old('cv_text') }}</textarea>
                    @error('cv_text')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Offre --}}
                <div>
                    <label for="job_offer_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Offre ciblée</label>
                    <select id="job_offer_id" name="job_offer_id"
                            class="block w-full border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-xl text-sm">
                        <option value="{{ $jobOffer->id }}" selected>{{ $jobOffer->title }}</option>
                    </select>
                    @error('job_offer_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-primary w-full py-3 text-base"
                        :disabled="submitting">
                    <span x-show="!submitting">Lancer l'analyse IA →</span>
                    <span x-show="submitting" class="flex items-center gap-2">
                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                        </svg>
                        Analyse en cours…
                    </span>
                </button>

                <p class="text-xs text-gray-400 dark:text-gray-500 text-center">L'analyse prend ~10 secondes et est effectuée en arrière-plan.</p>
            </form>
        </div>
    </div>
</x-app-layout>
