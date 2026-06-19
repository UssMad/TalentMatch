<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }} - AI-Powered Recruitment</title>

        @fonts

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /* Inline Tailwind v4 fallback - kept from original */
                @import url('https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap');
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body { font-family: 'Figtree', sans-serif; }
            </style>
        @endif
    </head>
    <body class="font-sans antialiased bg-white dark:bg-gray-950 text-gray-900 dark:text-gray-100">
        {{-- Navigation --}}
        <header class="fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-gray-950/80 backdrop-blur-md border-b border-gray-100 dark:border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-brand-600 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-gray-900 dark:text-white">TalentMatch</span>
                    </div>
                    <nav class="flex items-center gap-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="inline-flex items-center px-4 py-2 bg-brand-600 text-white text-sm font-medium rounded-lg hover:bg-brand-700 transition-colors">
                                    {{ __('Dashboard') }}
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-brand-600 dark:hover:text-brand-400 transition-colors">
                                    {{ __('Log in') }}
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-brand-600 text-white text-sm font-medium rounded-lg hover:bg-brand-700 transition-colors">
                                        {{ __('Register') }}
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </nav>
                </div>
            </div>
        </header>

        {{-- Hero Section --}}
        <section class="relative pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-brand-50 via-white to-white dark:from-gray-900 dark:via-gray-950 dark:to-gray-950"></div>
            <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-brand-100/50 to-transparent dark:from-brand-900/10 hidden lg:block"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-gray-900 dark:text-white leading-tight">
                        AI-Powered<br>
                        <span class="text-brand-600 dark:text-brand-400">Recruitment</span> Intelligence
                    </h1>
                    <p class="mt-6 text-lg sm:text-xl text-gray-600 dark:text-gray-300 leading-relaxed max-w-2xl">
                        Stop sifting through CVs manually. TalentMatch analyzes candidates against your job offers, computes matching scores, and lets you chat with an AI assistant to find the perfect hire — all in seconds.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-3 bg-brand-600 text-white font-semibold rounded-lg hover:bg-brand-700 shadow-lg shadow-brand-600/25 transition-all">
                                {{ __('Go to Dashboard') }}
                                <svg class="w-5 h-5 ms-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 bg-brand-600 text-white font-semibold rounded-lg hover:bg-brand-700 shadow-lg shadow-brand-600/25 transition-all">
                                {{ __('Get Started Free') }}
                                <svg class="w-5 h-5 ms-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                            <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                                {{ __('Sign In') }}
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </section>

        {{-- Features Section --}}
        <section class="py-20 lg:py-28 bg-gray-50 dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-16">
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white">
                        Built for <span class="text-brand-600 dark:text-brand-400">Modern Recruiters</span>
                    </h2>
                    <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">
                        Everything you need to evaluate candidates faster and make data-driven hiring decisions.
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-8 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-lg bg-brand-100 dark:bg-brand-900/50 flex items-center justify-center mb-5">
                            <svg class="w-6 h-6 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('AI-Powered Analysis') }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                            Automatically extract skills, experience, and qualifications from CVs. Our AI compares candidates against your job requirements with precision.
                        </p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl p-8 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-lg bg-success-100 dark:bg-success-900/50 flex items-center justify-center mb-5">
                            <svg class="w-6 h-6 text-success-600 dark:text-success-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('Smart Matching Scores') }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                            Get clear, data-driven matching scores from 0-100 for every candidate. Know instantly who to interview, who to watch, and who to pass on.
                        </p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl p-8 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-lg bg-warning-100 dark:bg-warning-900/50 flex items-center justify-center mb-5">
                            <svg class="w-6 h-6 text-warning-600 dark:text-warning-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('Conversational AI Assistant') }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                            Chat with an AI assistant about any candidate. Ask questions, compare candidates, and get detailed insights — all in natural language.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Stats Section --}}
        <section class="py-16 lg:py-20 bg-white dark:bg-gray-950">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 text-center">
                    <div>
                        <p class="text-4xl lg:text-5xl font-bold text-brand-600 dark:text-brand-400">100+</p>
                        <p class="mt-2 text-gray-600 dark:text-gray-400 font-medium">{{ __('Candidates Analyzed') }}</p>
                    </div>
                    <div>
                        <p class="text-4xl lg:text-5xl font-bold text-brand-600 dark:text-brand-400">50+</p>
                        <p class="mt-2 text-gray-600 dark:text-gray-400 font-medium">{{ __('Job Offers Posted') }}</p>
                    </div>
                    <div>
                        <p class="text-4xl lg:text-5xl font-bold text-brand-600 dark:text-brand-400">95%</p>
                        <p class="mt-2 text-gray-600 dark:text-gray-400 font-medium">{{ __('Accuracy Rate') }}</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- CTA Section --}}
        <section class="py-20 lg:py-28 bg-gradient-to-br from-brand-600 to-brand-800 dark:from-brand-700 dark:to-brand-900">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl sm:text-4xl font-bold text-white">
                    Ready to Transform Your Recruitment?
                </h2>
                <p class="mt-4 text-lg text-brand-100 max-w-2xl mx-auto">
                    Join recruiters who are saving hours every week with AI-powered candidate analysis. Start for free, no credit card required.
                </p>
                <div class="mt-8 flex flex-wrap justify-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-3 bg-white text-brand-700 font-semibold rounded-lg hover:bg-brand-50 shadow-lg transition-all">
                            {{ __('Go to Dashboard') }}
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 bg-white text-brand-700 font-semibold rounded-lg hover:bg-brand-50 shadow-lg transition-all">
                            {{ __('Get Started Free') }}
                            <svg class="w-5 h-5 ms-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                    @endauth
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <footer class="py-8 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded bg-brand-600 flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-600 dark:text-gray-400">TalentMatch</span>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-500">
                        &copy; {{ date('Y') }} {{ config('app.name', 'TalentMatch') }}. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </body>
</html>
