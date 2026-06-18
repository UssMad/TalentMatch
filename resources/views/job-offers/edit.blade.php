<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Job Offer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('job-offers.update', $jobOffer) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $jobOffer->title)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="6" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>{{ old('description', $jobOffer->description) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div>
                            <x-input-label :value="__('Required Skills')" />
                            <div id="skills-container" class="mt-1 space-y-2">
                                @foreach (old('required_skills', $jobOffer->required_skills) as $skill)
                                    <div class="flex gap-2">
                                        <x-text-input type="text" name="required_skills[]" value="{{ $skill }}" class="flex-1" required />
                                        <button type="button" onclick="this.parentElement.remove()" class="inline-flex items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            -
                                        </button>
                                    </div>
                                @endforeach
                                <div class="flex gap-2">
                                    <x-text-input type="text" name="required_skills[]" placeholder="e.g. PHP" class="flex-1" />
                                    <button type="button" onclick="addSkill()" class="inline-flex items-center px-3 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        +
                                    </button>
                                </div>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('required_skills')" />
                            <x-input-error class="mt-2" :messages="$errors->get('required_skills.*')" />
                        </div>

                        <div>
                            <x-input-label for="min_experience" :value="__('Minimum Experience (years)')" />
                            <x-text-input id="min_experience" name="min_experience" type="number" class="mt-1 block w-full" :value="old('min_experience', $jobOffer->min_experience)" min="0" required />
                            <x-input-error class="mt-2" :messages="$errors->get('min_experience')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Update') }}</x-primary-button>
                            <a href="{{ route('job-offers.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">{{ __('Cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function addSkill() {
            const container = document.getElementById('skills-container');
            const div = document.createElement('div');
            div.className = 'flex gap-2';
            div.innerHTML = `
                <input type="text" name="required_skills[]" placeholder="e.g. PHP" class="flex-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" />
                <button type="button" onclick="this.parentElement.remove()" class="inline-flex items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    -
                </button>
            `;
            container.appendChild(div);
        }
    </script>
    @endpush
</x-app-layout>
