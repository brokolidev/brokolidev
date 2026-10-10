<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full antialiased">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#09090b" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Primary Meta Tags -->
    <title>@yield('title', 'Ted Choi - Software Engineer | Full-Stack & AI-Assisted Developer')</title>
    <meta name="title" content="@yield('title', 'Ted Choi - Software Engineer | Full-Stack & AI-Assisted Developer')">
    <meta name="description" content="@yield('meta_description', 'Ted Choi is a Software Engineer based in Calgary with 10+ years of experience specializing in full-stack web development, PHP/Laravel, Node.js/NestJS, Docker, cloud infrastructure, and AI-first engineering.')">
    <meta name="keywords" content="@yield('meta_keywords', 'Ted Choi, Software Engineer, Full Stack Developer, Calgary, Alberta, Web Developer, PHP, Laravel, Node.js, NestJS, TypeScript, Docker, Cloud, AWS, GCP, Azure, AI Developer, brokolidev')">
    <meta name="author" content="Ted Choi">
    <meta name="robots" content="@yield('meta_robots', 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1')">
    <link rel="canonical" href="@yield('canonical_url', url()->current())" />

    <!-- Open Graph / Facebook / LinkedIn -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="brokolidev">
    <meta property="og:title" content="@yield('og_title', 'Ted Choi - Software Engineer | Full-Stack & AI-Assisted Developer')">
    <meta property="og:description" content="@yield('og_description', 'Ted Choi is a Software Engineer based in Calgary with 10+ years of experience specializing in full-stack web development, PHP/Laravel, Node.js/NestJS, Docker, cloud infrastructure, and AI-first engineering.')">
    <meta property="og:url" content="@yield('canonical_url', url()->current())">
    <meta property="og:image" content="@yield('og_image', asset('/img/profile.png'))">
    <meta property="og:image:alt" content="@yield('og_image_alt', 'Ted Choi - Software Engineer')">
    <meta property="og:locale" content="en_US">
    <meta property="og:locale:alternate" content="ko_KR">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="@yield('twitter_card', 'summary_large_image')">
    <meta name="twitter:title" content="@yield('og_title', 'Ted Choi - Software Engineer | Full-Stack & AI-Assisted Developer')">
    <meta name="twitter:description" content="@yield('og_description', 'Ted Choi is a Software Engineer based in Calgary with 10+ years of experience specializing in full-stack web development, PHP/Laravel, Node.js/NestJS, Docker, cloud infrastructure, and AI-driven solutions.')">
    <meta name="twitter:image" content="@yield('og_image', asset('/img/profile.png'))">
    <meta name="twitter:creator" content="@brokolidev">

    <!-- Favicons & Manifest -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
    <link rel="shortcut icon" href="{{ asset('/img/favicon.ico') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/img/favicon_io/favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/img/favicon_io/favicon-16x16.png') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/img/favicon_io/apple-touch-icon.png') }}" />
    <link rel="manifest" href="{{ asset('/img/favicon_io/site.webmanifest') }}" />

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-0KR5V5X1NT"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-0KR5V5X1NT');
    </script>

    <!-- Structured Data (JSON-LD Schema.org) -->
    @hasSection('json_ld')
        @yield('json_ld')
    @else
        @php
            $defaultSchema = [
                '@context' => 'https://schema.org',
                '@graph' => [
                    [
                        '@type' => 'WebSite',
                        '@id' => 'https://brokolidev.com/#website',
                        'url' => 'https://brokolidev.com',
                        'name' => 'brokolidev',
                        'description' => 'Portfolio and technical blog of Ted Choi, Software Engineer.',
                        'publisher' => [
                            '@id' => 'https://brokolidev.com/#person',
                        ],
                    ],
                    [
                        '@type' => 'ProfilePage',
                        '@id' => url()->current() . '#webpage',
                        'url' => url()->current(),
                        'name' => 'Ted Choi - Software Engineer',
                        'isPartOf' => [
                            '@id' => 'https://brokolidev.com/#website',
                        ],
                        'about' => [
                            '@id' => 'https://brokolidev.com/#person',
                        ],
                        'mainEntity' => [
                            '@id' => 'https://brokolidev.com/#person',
                        ],
                    ],
                    [
                        '@type' => 'Person',
                        '@id' => 'https://brokolidev.com/#person',
                        'name' => 'Ted Choi',
                        'alternateName' => ['brokolidev', '최원석', 'Ted'],
                        'jobTitle' => 'Software Engineer',
                        'description' => 'Software engineer with 10+ years of experience specializing in full-stack architecture, e-commerce platforms, cloud infrastructure, and AI-first engineering.',
                        'image' => asset('/img/profile.png'),
                        'url' => 'https://brokolidev.com',
                        'address' => [
                            '@type' => 'PostalAddress',
                            'addressLocality' => 'Calgary',
                            'addressRegion' => 'Alberta',
                            'addressCountry' => 'CA',
                        ],
                        'sameAs' => [
                            'https://github.com/brokolidev',
                            'https://www.linkedin.com/in/brokolidev/',
                            'https://www.facebook.com/bocalist',
                            'https://buymeacoffee.com/brokolidev',
                        ],
                        'knowsAbout' => [
                            'Software Engineering',
                            'Full Stack Development',
                            'PHP',
                            'Laravel',
                            'Node.js',
                            'NestJS',
                            'TypeScript',
                            'Docker',
                            'DevOps & CI/CD',
                            'Cloud Infrastructure',
                            'Amazon Web Services (AWS)',
                            'Microsoft Azure',
                            'Google Cloud Platform (GCP)',
                            'Artificial Intelligence',
                            'E-commerce Architecture',
                        ],
                    ],
                ],
            ];
        @endphp
        <script type="application/ld+json">
        {!! json_encode($defaultSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) !!}
        </script>
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://rsms.me/">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Styles -->
    @vite('resources/css/app.css')

    <!-- Scripts -->
    @vite('resources/js/app.js')

    <!-- Theme Initialization -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="relative flex min-h-full flex-col bg-zinc-50 dark:bg-zinc-950 text-zinc-800 dark:text-zinc-200 selection:bg-teal-500 selection:text-white transition-colors duration-300 overflow-x-hidden">
    <!-- Ambient Background Light Effects -->
    <div class="fixed inset-0 pointer-events-none -z-10 overflow-hidden" aria-hidden="true">
        <div class="absolute -top-36 left-1/2 -translate-x-1/2 w-[700px] h-[450px] bg-gradient-to-tr from-teal-400/20 via-indigo-500/15 to-transparent blur-3xl rounded-full dark:from-teal-500/10 dark:via-cyan-600/5 dark:to-transparent animate-float-slow"></div>
        <div class="absolute top-96 -right-24 w-[480px] h-[360px] bg-gradient-to-bl from-indigo-500/15 via-purple-500/10 to-transparent blur-3xl rounded-full dark:from-indigo-600/10 dark:to-transparent animate-float-reverse"></div>
    </div>

    <!-- Header / Navbar -->
    <header class="relative z-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-8 lg:px-12 pt-6">
            <div class="mx-auto max-w-2xl lg:max-w-4xl flex items-center justify-between">
                <!-- Brand / Logo -->
                <a href="/" class="group flex items-center text-zinc-900 dark:text-zinc-100 font-bold text-base tracking-tight transition-opacity duration-200 hover:opacity-80">
                    <span>brokoli<span class="text-teal-600 dark:text-teal-400 font-semibold">.dev</span></span>
                </a>

                <!-- Navigation Links & Theme Toggle -->
                <nav class="flex items-center gap-1.5 sm:gap-2">
                    <a href="/" class="px-3 py-1.5 rounded-lg text-xs font-semibold text-teal-700 bg-teal-50 border border-teal-200/80 dark:bg-teal-950/40 dark:text-teal-300 dark:border-teal-500/30 transition-all duration-200 shadow-2xs">
                        <span>Profile</span>
                    </a>
                    <a href="https://blog.brokolidev.com" class="px-3 py-1.5 rounded-lg text-xs font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 hover:bg-zinc-100 dark:hover:bg-zinc-800/80 transition-all duration-200">
                        <span>Blog</span>
                    </a>
                    <a href="https://history.brokolidev.com" class="px-3 py-1.5 rounded-lg text-xs font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 hover:bg-zinc-100 dark:hover:bg-zinc-800/80 transition-all duration-200">
                        <span>History</span>
                    </a>
                    <a href="/game" class="px-3 py-1.5 rounded-lg text-xs font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 hover:bg-zinc-100 dark:hover:bg-zinc-800/80 transition-all duration-200">
                        <span>Game</span>
                    </a>

                    <!-- Theme Toggle -->
                    <button type="button" id="theme-toggle" aria-label="Toggle theme" class="group flex h-8 w-8 items-center justify-center rounded-lg border border-zinc-200 bg-white text-zinc-600 transition-all duration-200 hover:-translate-y-0.5 hover:border-zinc-300 hover:text-zinc-900 hover:shadow-xs dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-400 dark:hover:border-zinc-700 dark:hover:text-zinc-100 cursor-pointer active:scale-95">
                        <i class="fas fa-sun hidden dark:block text-amber-400 text-xs transition-transform duration-300 group-hover:rotate-45"></i>
                        <i class="fas fa-moon block dark:hidden text-zinc-600 text-xs transition-transform duration-300 group-hover:-rotate-12"></i>
                    </button>
                </nav>
            </div>
        </div>
    </header>

    <main class="flex-auto">
        @section('contents')
        <div class="sm:px-8 mt-6 sm:mt-10 pb-16">
            <div class="mx-auto max-w-7xl lg:px-8">
                <div class="relative px-4 sm:px-8 lg:px-12">
                    <div class="mx-auto max-w-2xl lg:max-w-4xl">
                        <!-- Profile Header -->
                        <div id="about" class="animate-fade-in-up [animation-delay:100ms] flex flex-col sm:flex-row sm:items-start sm:justify-between gap-6 pb-12 border-b border-zinc-200 dark:border-zinc-800">
                            <div>
                                <div class="flex items-center gap-2.5">
                                    <h1 id="hero-name" class="text-2xl sm:text-3xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100 cursor-default">Ted Choi</h1>
                                    <span class="inline-flex items-center gap-1.5 rounded-md bg-teal-50 px-2 py-0.5 text-xs font-medium text-teal-700 ring-1 ring-inset ring-teal-700/10 dark:bg-teal-400/10 dark:text-teal-400 dark:ring-teal-400/20">
                                        <span class="relative flex h-1.5 w-1.5">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-teal-500"></span>
                                        </span>
                                        Active
                                    </span>
                                </div>
                                    <div class="flex flex-wrap items-center gap-y-1 gap-x-3 text-sm text-zinc-600 dark:text-zinc-400 mt-1.5 font-mono">
                                        <span class="inline-flex items-center gap-1.5 cursor-default group/role">
                                            <i class="fas fa-code text-teal-600 dark:text-teal-400 text-xs animate-glitch"></i>
                                            <span id="typing-role" data-role="Software Engineer" class="text-zinc-800 dark:text-zinc-200 font-semibold">Software Engineer</span>
                                            <span class="animate-cursor text-teal-500 font-bold ml-0.5" aria-hidden="true">_</span>
                                        </span>
                                        <span>•</span>
                                        <span class="flex items-center gap-1.5">
                                            <i class="fas fa-location-dot text-zinc-400 text-xs"></i>
                                            Calgary, Alberta
                                        </span>
                                    </div>

                                    <!-- Bio Text -->
                                    <p class="mt-3 text-xs sm:text-sm text-zinc-600 dark:text-zinc-400 leading-normal">
                                        An amateur bowler, an amateur soccer player, a reader, a listener, and a software engineer.
                                    </p>

                                    <!-- Threads Style Tags -->
                                    <div class="flex flex-wrap items-center gap-1.5 mt-3">
                                        <span class="inline-flex items-center rounded-full bg-zinc-100 dark:bg-zinc-800/90 px-3 py-0.5 text-xs font-medium text-zinc-700 dark:text-zinc-300 border border-zinc-200/80 dark:border-zinc-700/60 hover:bg-zinc-200 dark:hover:bg-zinc-700 hover:scale-105 active:scale-95 transition-all duration-200 cursor-default shadow-xs">soccer</span>
                                        <span class="inline-flex items-center rounded-full bg-zinc-100 dark:bg-zinc-800/90 px-3 py-0.5 text-xs font-medium text-zinc-700 dark:text-zinc-300 border border-zinc-200/80 dark:border-zinc-700/60 hover:bg-zinc-200 dark:hover:bg-zinc-700 hover:scale-105 active:scale-95 transition-all duration-200 cursor-default shadow-xs">bowling</span>
                                        <span class="inline-flex items-center rounded-full bg-zinc-100 dark:bg-zinc-800/90 px-3 py-0.5 text-xs font-medium text-zinc-700 dark:text-zinc-300 border border-zinc-200/80 dark:border-zinc-700/60 hover:bg-zinc-200 dark:hover:bg-zinc-700 hover:scale-105 active:scale-95 transition-all duration-200 cursor-default shadow-xs">books</span>
                                        <span class="inline-flex items-center rounded-full bg-zinc-100 dark:bg-zinc-800/90 px-3 py-0.5 text-xs font-medium text-zinc-700 dark:text-zinc-300 border border-zinc-200/80 dark:border-zinc-700/60 hover:bg-zinc-200 dark:hover:bg-zinc-700 hover:scale-105 active:scale-95 transition-all duration-200 cursor-default shadow-xs">movies</span>
                                        <span class="inline-flex items-center rounded-full bg-zinc-100 dark:bg-zinc-800/90 px-3 py-0.5 text-xs font-medium text-zinc-700 dark:text-zinc-300 border border-zinc-200/80 dark:border-zinc-700/60 hover:bg-zinc-200 dark:hover:bg-zinc-700 hover:scale-105 active:scale-95 transition-all duration-200 cursor-default shadow-xs">music</span>
                                    </div>
                                </div>
                            <!-- Social Connects -->
                            <div class="flex items-center justify-end gap-2">
                                <a href="https://github.com/brokolidev" target="_blank" rel="noopener noreferrer" class="group flex h-9 w-9 items-center justify-center rounded-lg border border-zinc-200 bg-white text-zinc-600 transition-all duration-200 hover:-translate-y-0.5 hover:border-zinc-300 hover:text-zinc-900 hover:shadow-sm dark:border-zinc-800 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:border-zinc-700 dark:hover:text-zinc-100 active:scale-95" aria-label="GitHub">
                                    <i class="fab fa-github text-base transition-transform group-hover:scale-110"></i>
                                </a>
                                <a href="https://www.linkedin.com/in/brokolidev/" target="_blank" rel="noopener noreferrer" class="group flex h-9 w-9 items-center justify-center rounded-lg border border-zinc-200 bg-white text-zinc-600 transition-all duration-200 hover:-translate-y-0.5 hover:border-zinc-300 hover:text-blue-600 hover:shadow-sm dark:border-zinc-800 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:border-zinc-700 dark:hover:text-blue-400 active:scale-95" aria-label="LinkedIn">
                                    <i class="fab fa-linkedin-in text-base transition-transform group-hover:scale-110"></i>
                                </a>
                                <a href="https://www.facebook.com/bocalist" target="_blank" rel="noopener noreferrer" class="group flex h-9 w-9 items-center justify-center rounded-lg border border-zinc-200 bg-white text-zinc-600 transition-all duration-200 hover:-translate-y-0.5 hover:border-zinc-300 hover:text-blue-500 hover:shadow-sm dark:border-zinc-800 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:border-zinc-700 dark:hover:text-blue-400 active:scale-95" aria-label="Facebook">
                                    <i class="fab fa-facebook-f text-base transition-transform group-hover:scale-110"></i>
                                </a>
                                <a href="https://buymeacoffee.com/brokolidev" target="_blank" rel="noopener noreferrer" class="group flex h-9 w-9 items-center justify-center rounded-lg border border-zinc-200 bg-white text-zinc-600 transition-all duration-200 hover:-translate-y-0.5 hover:border-zinc-300 hover:text-amber-500 hover:shadow-sm dark:border-zinc-800 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:border-zinc-700 dark:hover:text-amber-400 active:scale-95" aria-label="Buy Me a Coffee">
                                    <i class="fas fa-mug-hot text-base transition-transform group-hover:scale-110"></i>
                                </a>
                                <a href="mailto:bocalist@gmail.com" class="group flex h-9 w-9 items-center justify-center rounded-lg border border-zinc-200 bg-white text-zinc-600 transition-all duration-200 hover:-translate-y-0.5 hover:border-zinc-300 hover:text-teal-600 hover:shadow-sm dark:border-zinc-800 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:border-zinc-700 dark:hover:text-teal-400 active:scale-95" aria-label="Email">
                                    <i class="fas fa-envelope text-base transition-transform group-hover:scale-110"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Featured Section: AI Perspective (Clearly Distinct) -->
                        <div id="ai-mindset" class="mt-12 animate-fade-in-up [animation-delay:200ms] transition-all duration-300 hover:-translate-y-1">
                            <div class="relative overflow-hidden rounded-2xl border border-teal-500/30 bg-gradient-to-br from-teal-500/[0.06] via-white/80 to-indigo-500/[0.04] dark:from-teal-500/[0.09] dark:via-zinc-900/90 dark:to-indigo-500/[0.06] p-6 sm:p-8 shadow-sm hover:shadow-xl hover:shadow-teal-500/5 dark:hover:shadow-teal-500/10 backdrop-blur-sm transition-all duration-300">
                                <div class="flex items-center gap-2 mb-4">
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-teal-500/10 px-3 py-1 text-xs font-semibold text-teal-700 dark:text-teal-300 border border-teal-500/20">
                                        <span class="relative flex h-1.5 w-1.5">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-teal-500"></span>
                                        </span>
                                        AI-First Engineering Mindset
                                    </span>
                                </div>
                                <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
                                    Q. What is your perspective on AI?
                                </h2>
                                <div class="mt-4 space-y-4 text-base leading-relaxed text-zinc-700 dark:text-zinc-300">
                                    <p>
                                        I now spend the vast majority of my working hours actively collaborating with and leveraging <strong class="font-semibold text-zinc-900 dark:text-zinc-100">AI</strong>. Today, AI has evolved beyond software engineering into an indispensable foundation across all industries, and how effectively one utilizes AI directly reflects an engineer's capability and impact.
                                    </p>
                                    <p>
                                        I utilize AI as a powerful catalyst to bridge previous knowledge gaps and elevate my problem-solving ability, experiencing dramatic leaps in productivity and execution speed every single day. In this era, specific programming languages, platforms, or domains are no longer the bottleneck—what truly matters is the vision you dream and dare to build.
                                    </p>
                                </div>
                                <div class="mt-6 pt-5 border-t border-teal-500/10 flex items-center gap-2 text-xs font-medium text-zinc-500 dark:text-zinc-400">
                                    <i class="fas fa-arrow-down text-teal-600 dark:text-teal-400 animate-bounce"></i>
                                    <span>Curious about my traditional foundation and tech stacks? Explore the legacy archive below.</span>
                                </div>
                            </div>
                        </div>

                        <!-- Technical Divider -->
                        <div id="qa-archive" class="relative my-12 sm:my-14 animate-fade-in-up [animation-delay:300ms]">
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="w-full border-t border-zinc-200 dark:border-zinc-800"></div>
                            </div>
                            <div class="relative flex justify-center">
                                <span class="bg-zinc-50 dark:bg-zinc-950 px-4 font-mono text-xs font-medium uppercase tracking-wider text-zinc-400 dark:text-zinc-500">
                                    // Technical Background & Q&A
                                </span>
                            </div>
                        </div>

                        <!-- Legacy Q&A Grid -->
                        <div class="grid gap-6 animate-fade-in-up [animation-delay:400ms]">
                            <!-- Q1 -->
                            <div class="group rounded-xl border border-zinc-200/80 bg-white/70 dark:border-zinc-800/80 dark:bg-zinc-900/40 p-6 shadow-sm hover:-translate-y-1 hover:shadow-md hover:border-teal-500/40 dark:hover:border-teal-500/40 backdrop-blur-sm transition-all duration-300">
                                <span class="font-mono text-xs font-semibold text-teal-600 dark:text-teal-400 group-hover:text-teal-500 uppercase tracking-wider transition-colors duration-200">01 / Background</span>
                                <h3 class="mt-1.5 text-base sm:text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                                    Q. Tell me about your background and experience.
                                </h3>
                                <p class="mt-3 text-sm sm:text-base leading-relaxed text-zinc-600 dark:text-zinc-300">
                                    I began my career as an <strong class="font-semibold text-zinc-900 dark:text-zinc-100">IT Security Manager</strong>, which provided me with a solid foundation in IT infrastructure and security. Over the past 10+ years, I have worked as a Software Engineer, focusing primarily on <strong class="font-semibold text-zinc-900 dark:text-zinc-100">PHP-based</strong> platforms ranging from large-scale e-commerce systems to custom CMS solutions.
                                </p>
                            </div>

                            <!-- Q2 -->
                            <div class="group rounded-xl border border-zinc-200/80 bg-white/70 dark:border-zinc-800/80 dark:bg-zinc-900/40 p-6 shadow-sm hover:-translate-y-1 hover:shadow-md hover:border-teal-500/40 dark:hover:border-teal-500/40 backdrop-blur-sm transition-all duration-300">
                                <span class="font-mono text-xs font-semibold text-teal-600 dark:text-teal-400 group-hover:text-teal-500 uppercase tracking-wider transition-colors duration-200">02 / Domain & Philosophy</span>
                                <h3 class="mt-1.5 text-base sm:text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                                    Q. Which domain or field are you most confident in?
                                </h3>
                                <p class="mt-3 text-sm sm:text-base leading-relaxed text-zinc-600 dark:text-zinc-300">
                                    Most of the companies I have worked with specialized in digital commerce, allowing me to build deep expertise in the <strong class="font-semibold text-zinc-900 dark:text-zinc-100">E-commerce</strong> domain. Additionally, through my hands-on experience in various startups, I have developed the ability to build infrastructure from the ground up for small-to-medium-sized projects. I believe developers are creators who turn imagination into reality—transforming abstract, ambiguous requirements into reliable, production-ready services, with the ultimate goal of delivering tangible value to real-world businesses.
                                </p>
                            </div>

                            <!-- Q3 -->
                            <div class="group rounded-xl border border-zinc-200/80 bg-white/70 dark:border-zinc-800/80 dark:bg-zinc-900/40 p-6 shadow-sm hover:-translate-y-1 hover:shadow-md hover:border-teal-500/40 dark:hover:border-teal-500/40 backdrop-blur-sm transition-all duration-300">
                                <span class="font-mono text-xs font-semibold text-teal-600 dark:text-teal-400 group-hover:text-teal-500 uppercase tracking-wider transition-colors duration-200">03 / Modern Stack</span>
                                <h3 class="mt-1.5 text-base sm:text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                                    Q. What is your experience with Node.js?
                                </h3>
                                <p class="mt-3 text-sm sm:text-base leading-relaxed text-zinc-600 dark:text-zinc-300">
                                    I actively follow modern engineering trends and understand the performance benefits of the Node.js ecosystem. While my core experience is in PHP, I have a strong grasp of Node.js fundamentals. Currently, I am contributing to a project building backend services with <strong class="font-semibold text-zinc-900 dark:text-zinc-100">NestJS</strong>. I believe that focusing on core architectural principles rather than just language syntax allows me to adapt quickly and deliver reliable solutions in any stack.
                                </p>
                            </div>

                            <!-- Q4 -->
                            <div class="group rounded-xl border border-zinc-200/80 bg-white/70 dark:border-zinc-800/80 dark:bg-zinc-900/40 p-6 shadow-sm hover:-translate-y-1 hover:shadow-md hover:border-teal-500/40 dark:hover:border-teal-500/40 backdrop-blur-sm transition-all duration-300">
                                <span class="font-mono text-xs font-semibold text-teal-600 dark:text-teal-400 group-hover:text-teal-500 uppercase tracking-wider transition-colors duration-200">04 / DevOps & Containers</span>
                                <h3 class="mt-1.5 text-base sm:text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                                    Q. How proficient are you with Docker?
                                </h3>
                                <p class="mt-3 text-sm sm:text-base leading-relaxed text-zinc-600 dark:text-zinc-300">
                                    For the past several years, I have consistently used <strong class="font-semibold text-zinc-900 dark:text-zinc-100">Docker and Docker Compose</strong> across all my projects to standardize development environments and eliminate inconsistencies across team members. I am also experienced in containerizing applications and configuring CI/CD workflows. Given my backend background, I am particularly adept at orchestrating <strong class="font-semibold text-zinc-900 dark:text-zinc-100">Nginx, PHP, and MySQL</strong> within containerized environments.
                                </p>
                            </div>

                            <!-- Q5 -->
                            <div class="group rounded-xl border border-zinc-200/80 bg-white/70 dark:border-zinc-800/80 dark:bg-zinc-900/40 p-6 shadow-sm hover:-translate-y-1 hover:shadow-md hover:border-teal-500/40 dark:hover:border-teal-500/40 backdrop-blur-sm transition-all duration-300">
                                <span class="font-mono text-xs font-semibold text-teal-600 dark:text-teal-400 group-hover:text-teal-500 uppercase tracking-wider transition-colors duration-200">05 / Full-Stack Spectrum</span>
                                <h3 class="mt-1.5 text-base sm:text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                                    Q. Do you prefer frontend or backend development?
                                </h3>
                                <p class="mt-3 text-sm sm:text-base leading-relaxed text-zinc-600 dark:text-zinc-300">
                                    With modern web development blurring the lines between client and server, I value both equally. <strong class="font-semibold text-zinc-900 dark:text-zinc-100">Frontend</strong> development is exciting because of immediate visual feedback and crafting seamless user experiences, while <strong class="font-semibold text-zinc-900 dark:text-zinc-100">backend</strong> engineering is deeply rewarding when designing scalable architectures and optimizing performance. Ultimately, my priority is contributing wherever the product and team need it most.
                                </p>
                            </div>

                            <!-- Q6 -->
                            <div class="group rounded-xl border border-zinc-200/80 bg-white/70 dark:border-zinc-800/80 dark:bg-zinc-900/40 p-6 shadow-sm hover:-translate-y-1 hover:shadow-md hover:border-teal-500/40 dark:hover:border-teal-500/40 backdrop-blur-sm transition-all duration-300">
                                <span class="font-mono text-xs font-semibold text-teal-600 dark:text-teal-400 group-hover:text-teal-500 uppercase tracking-wider transition-colors duration-200">06 / Infrastructure & Cloud</span>
                                <h3 class="mt-1.5 text-base sm:text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                                    Q. How experienced are you with server and cloud infrastructure?
                                </h3>
                                <p class="mt-3 text-sm sm:text-base leading-relaxed text-zinc-600 dark:text-zinc-300">
                                    Having worked in environments where full-cycle ownership was essential, I naturally developed strong capabilities in server administration and DevOps. With the widespread adoption of <strong class="font-semibold text-zinc-900 dark:text-zinc-100">cloud platforms</strong>, I have gained practical experience architecting infrastructure and establishing automated CI/CD pipelines across AWS, Azure, and GCP. While many organizations now have dedicated infrastructure specialists, my practical knowledge allows me to collaborate effectively and bridge the gap between development and operations.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @show
    </main>

    <!-- Footer -->
    <footer class="mt-auto border-t border-zinc-200 dark:border-zinc-800 bg-white/50 dark:bg-zinc-900/50 py-8 backdrop-blur-sm">
        <div class="mx-auto max-w-7xl px-4 sm:px-8 lg:px-12">
            <div class="mx-auto max-w-2xl lg:max-w-4xl flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-zinc-500 dark:text-zinc-400 text-center sm:text-left">
                    Connect on any platform — I typically respond within 1–2 business days.
                </p>
                <p class="text-xs font-mono text-zinc-400 dark:text-zinc-500">
                    &copy; {{ date('Y') }} brokolidev.com · Ted Choi
                </p>
            </div>
        </div>
    </footer>

    <!-- Buy Me a Coffee Floating Banner -->
    <aside id="bmc-floating-widget" aria-label="Support with a coffee" class="fixed bottom-5 right-5 sm:bottom-7 sm:right-7 z-50 flex items-center group transition-all duration-300">
        <!-- Floating Action Button -->
        <a href="https://buymeacoffee.com/brokolidev" 
           target="_blank" 
           rel="noopener noreferrer" 
           class="relative flex items-center gap-2.5 rounded-full bg-gradient-to-r from-amber-400 via-amber-500 to-yellow-500 px-4 py-2.5 sm:px-5 sm:py-3 text-zinc-950 font-semibold text-xs sm:text-sm shadow-lg shadow-amber-500/25 hover:shadow-xl hover:shadow-amber-500/40 border border-amber-300/60 hover:-translate-y-1 hover:scale-105 active:scale-95 transition-all duration-300 backdrop-blur-md cursor-pointer select-none">
            
            <!-- Animated Ping Badge -->
            <span class="absolute -top-1 -right-1 flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-500 ring-2 ring-white dark:ring-zinc-950"></span>
            </span>

            <!-- Coffee Mug Icon -->
            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-zinc-950/10 transition-transform duration-300 group-hover:rotate-12">
                <i class="fas fa-mug-hot text-zinc-950 text-xs sm:text-sm"></i>
            </span>

            <!-- Text Content -->
            <span class="font-medium tracking-tight whitespace-nowrap">
                Buy me a coffee
            </span>
        </a>

        <!-- Dismiss button -->
        <button type="button" 
                id="bmc-dismiss-btn" 
                aria-label="Close coffee banner" 
                title="Dismiss"
                class="ml-1.5 flex h-6 w-6 items-center justify-center rounded-full bg-zinc-900/60 hover:bg-zinc-900/90 text-zinc-300 hover:text-white dark:bg-zinc-800/80 dark:hover:bg-zinc-700 text-xs backdrop-blur-md opacity-0 group-hover:opacity-100 transition-all duration-200 cursor-pointer shadow-xs active:scale-90">
            <i class="fas fa-times text-[10px]"></i>
        </button>
    </aside>

    <script>
        // Theme toggle
        document.getElementById('theme-toggle')?.addEventListener('click', function () {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.theme = isDark ? 'dark' : 'light';
        });

        // Hacker Scramble / Cyber Decryption Typing Effect
        function scrambleText(element, targetText, duration = 850) {
            const chars = '!<>-_\\/[]{}—=+*^?#01~;:$';
            let start = null;
            const length = targetText.length;

            function step(timestamp) {
                if (!start) start = timestamp;
                const elapsed = timestamp - start;
                const progress = Math.min(elapsed / duration, 1);
                const resolvedIndex = Math.floor(progress * length);

                let output = '';
                for (let i = 0; i < length; i++) {
                    if (i < resolvedIndex) {
                        output += targetText[i];
                    } else if (targetText[i] === ' ') {
                        output += ' ';
                    } else {
                        output += chars[Math.floor(Math.random() * chars.length)];
                    }
                }
                element.textContent = output;

                if (progress < 1) {
                    requestAnimationFrame(step);
                } else {
                    element.textContent = targetText;
                }
            }
            requestAnimationFrame(step);
        }

        // Initialize effects
        const roleEl = document.getElementById('typing-role');
        if (roleEl) {
            const originalRole = roleEl.dataset.role || 'Software Engineer';
            let isHovered = false;

            // Initial scramble on page load
            setTimeout(() => {
                scrambleText(roleEl, originalRole, 850);
            }, 350);

            // Re-trigger on hover
            const roleContainer = roleEl.closest('.group\\/role');
            if (roleContainer) {
                roleContainer.addEventListener('mouseenter', () => {
                    isHovered = true;
                    scrambleText(roleEl, originalRole, 600);
                });
                roleContainer.addEventListener('mouseleave', () => {
                    isHovered = false;
                });
            }

            // Recurring scramble every 5.5 seconds
            setInterval(() => {
                if (!isHovered) {
                    scrambleText(roleEl, originalRole, 750);
                }
            }, 5500);
        }

        const nameEl = document.getElementById('hero-name');
        if (nameEl) {
            nameEl.addEventListener('mouseenter', () => {
                scrambleText(nameEl, 'Ted Choi', 450);
            });
        }

        // Buy Me a Coffee widget dismiss logic
        const bmcWidget = document.getElementById('bmc-floating-widget');
        const bmcDismissBtn = document.getElementById('bmc-dismiss-btn');
        if (bmcWidget && bmcDismissBtn) {
            if (sessionStorage.getItem('bmc_dismissed') === 'true') {
                bmcWidget.style.display = 'none';
            }
            bmcDismissBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                bmcWidget.style.opacity = '0';
                bmcWidget.style.transform = 'translateY(12px) scale(0.95)';
                bmcWidget.style.transition = 'all 0.25s ease-out';
                setTimeout(() => {
                    bmcWidget.style.display = 'none';
                }, 250);
                sessionStorage.setItem('bmc_dismissed', 'true');
            });
        }
    </script>
</body>

</html>