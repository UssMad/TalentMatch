<x-app-layout>
    @section('title', 'Modifier l\'offre')

    <div class="max-w-2xl mx-auto space-y-6">
        <h1 class="text-xl text-gray-900 dark:text-gray-100">Modifier l'offre</h1>

        <div class="card">
            <form method="POST" action="{{ route('job-offers.update', $jobOffer) }}" class="space-y-5" x-data="skillManager({{ json_encode(old('required_skills', $jobOffer->required_skills ?? [])) }})">
                @csrf
                @method('PUT')

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Titre</label>
                    <input id="title" name="title" type="text" value="{{ old('title', $jobOffer->title) }}"
                           class="block w-full border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-xl text-sm" required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                    <textarea id="description" name="description" rows="8"
                              class="block w-full border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-xl text-sm resize-y" required>{{ old('description', $jobOffer->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Compétences requises</label>
                    <div id="skills-container" class="space-y-2">
                        <template x-for="(skill, i) in skills" :key="i">
                            <div class="flex gap-2">
                                <input type="text" :name="'required_skills[]'" x-model="skills[i]"
                                       class="flex-1 border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-xl text-sm" required>
                                <button type="button" @click="removeSkill(i)"
                                        class="btn-danger px-3 py-2 text-xs"
                                        x-show="skills.length > 1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </div>
                    <button type="button" @click="addSkill()"
                            class="mt-2 text-sm font-medium text-brand-600 dark:text-brand-400 hover:text-brand-700 dark:hover:text-brand-300 transition-colors flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Ajouter une compétence
                    </button>
                    @error('required_skills')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @error('required_skills.*')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="min_experience" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Expérience minimale (années)</label>
                    <input id="min_experience" name="min_experience" type="number" value="{{ old('min_experience', $jobOffer->min_experience) }}"
                           class="block w-32 border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-xl text-sm" min="0" required>
                    @error('min_experience')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="btn-primary">Enregistrer</button>
                    <a href="{{ route('job-offers.index') }}" class="btn-outline">Annuler</a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('skillManager', (initialSkills) => ({
                skills: initialSkills.length ? initialSkills : [''],

                addSkill() {
                    this.skills.push('');
                },

                removeSkill(i) {
                    this.skills.splice(i, 1);
                },
            }));
        });
    </script>
    @endpush
</x-app-layout>
