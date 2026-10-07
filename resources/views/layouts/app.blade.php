<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full antialiased">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#09090b" />
    <link rel="shortcut icon" href="{{ asset('/img/favicon.ico') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Ted Choi - Software Engineer</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://rsms.me/">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('/img/apple-icon.png') }}" />
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

<body class="flex min-h-full flex-col bg-zinc-50 dark:bg-zinc-950 text-zinc-800 dark:text-zinc-200 selection:bg-teal-500 selection:text-white transition-colors duration-200">
    <header class="relative z-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-8 lg:px-12 pt-6">
            <div class="mx-auto max-w-2xl lg:max-w-4xl flex justify-end">
                <button type="button" id="theme-toggle" aria-label="Toggle theme" class="group flex h-9 w-9 items-center justify-center rounded-lg border border-zinc-200 bg-white text-zinc-600 transition hover:border-zinc-300 hover:text-zinc-900 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-400 dark:hover:border-zinc-700 dark:hover:text-zinc-100 shadow-sm cursor-pointer">
                    <i class="fas fa-sun hidden dark:block text-amber-400 text-sm transition group-hover:rotate-45"></i>
                    <i class="fas fa-moon block dark:hidden text-zinc-600 text-sm transition group-hover:-rotate-12"></i>
                </button>
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
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 pb-12 border-b border-zinc-200 dark:border-zinc-800">
                            <div class="flex items-center gap-5">
                                <img src="{{ asset('/img/profile.png') }}" alt="Ted Choi" class="h-20 w-20 sm:h-24 sm:w-24" />
                                <div>
                                    <div class="flex items-center gap-2.5">
                                        <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">Ted Choi</h1>
                                        <span class="inline-flex items-center rounded-md bg-teal-50 px-2 py-0.5 text-xs font-medium text-teal-700 ring-1 ring-inset ring-teal-700/10 dark:bg-teal-400/10 dark:text-teal-400 dark:ring-teal-400/20">Active</span>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-y-1 gap-x-3 text-sm text-zinc-600 dark:text-zinc-400 mt-1.5 font-mono">
                                        <span class="flex items-center gap-1.5">
                                            <i class="fas fa-code text-teal-600 dark:text-teal-400 text-xs"></i>
                                            Software Engineer
                                        </span>
                                        <span>•</span>
                                        <span class="flex items-center gap-1.5">
                                            <i class="fas fa-location-dot text-zinc-400 text-xs"></i>
                                            Calgary, Alberta
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- Social Connects -->
                            <div class="flex items-center justify-end gap-2">
                                <a href="https://github.com/brokolidev" target="_blank" rel="noopener noreferrer" class="group flex h-9 w-9 items-center justify-center rounded-lg border border-zinc-200 bg-white text-zinc-600 transition hover:border-zinc-300 hover:text-zinc-900 dark:border-zinc-800 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:border-zinc-700 dark:hover:text-zinc-100 shadow-sm" aria-label="GitHub">
                                    <i class="fab fa-github text-base transition group-hover:scale-110"></i>
                                </a>
                                <a href="https://www.linkedin.com/in/brokolidev/" target="_blank" rel="noopener noreferrer" class="group flex h-9 w-9 items-center justify-center rounded-lg border border-zinc-200 bg-white text-zinc-600 transition hover:border-zinc-300 hover:text-blue-600 dark:border-zinc-800 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:border-zinc-700 dark:hover:text-blue-400 shadow-sm" aria-label="LinkedIn">
                                    <i class="fab fa-linkedin-in text-base transition group-hover:scale-110"></i>
                                </a>
                                <a href="https://www.facebook.com/bocalist" target="_blank" rel="noopener noreferrer" class="group flex h-9 w-9 items-center justify-center rounded-lg border border-zinc-200 bg-white text-zinc-600 transition hover:border-zinc-300 hover:text-blue-500 dark:border-zinc-800 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:border-zinc-700 dark:hover:text-blue-400 shadow-sm" aria-label="Facebook">
                                    <i class="fab fa-facebook-f text-base transition group-hover:scale-110"></i>
                                </a>
                                <a href="mailto:bocalist@gmail.com" class="group flex h-9 w-9 items-center justify-center rounded-lg border border-zinc-200 bg-white text-zinc-600 transition hover:border-zinc-300 hover:text-teal-600 dark:border-zinc-800 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:border-zinc-700 dark:hover:text-teal-400 shadow-sm" aria-label="Email">
                                    <i class="fas fa-envelope text-base transition group-hover:scale-110"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Featured Section: AI Perspective (Clearly Distinct) -->
                        <div class="mt-12">
                            <div class="relative overflow-hidden rounded-2xl border border-teal-500/30 bg-gradient-to-br from-teal-500/[0.05] via-white to-indigo-500/[0.03] dark:from-teal-500/[0.08] dark:via-zinc-900 dark:to-indigo-500/[0.05] p-6 sm:p-8 shadow-sm">
                                <div class="flex items-center gap-2 mb-4">
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-teal-500/10 px-3 py-1 text-xs font-semibold text-teal-700 dark:text-teal-300 border border-teal-500/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-teal-500 animate-pulse"></span>
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
                                    <i class="fas fa-arrow-down text-teal-600 dark:text-teal-400"></i>
                                    <span>Curious about my traditional foundation and tech stacks? Explore the legacy archive below.</span>
                                </div>
                            </div>
                        </div>

                        <!-- Technical Divider -->
                        <div class="relative my-12 sm:my-14">
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="w-full border-t border-zinc-200 dark:border-zinc-800"></div>
                            </div>
                            <div class="relative flex justify-center">
                                <span class="bg-zinc-50 dark:bg-zinc-900 px-4 font-mono text-xs font-medium uppercase tracking-wider text-zinc-400 dark:text-zinc-500">
                                    // Technical Background & Q&A
                                </span>
                            </div>
                        </div>

                        <!-- Legacy Q&A Grid -->
                        <div class="grid gap-6">
                            <!-- Q1 -->
                            <div class="rounded-xl border border-zinc-200/80 bg-white/70 dark:border-zinc-800/80 dark:bg-zinc-900/40 p-6 shadow-sm hover:border-zinc-300 dark:hover:border-zinc-700 transition">
                                <span class="font-mono text-xs font-semibold text-teal-600 dark:text-teal-400 uppercase tracking-wider">01 / Background</span>
                                <h3 class="mt-1.5 text-base sm:text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                                    Q. Tell me about your background and experience.
                                </h3>
                                <p class="mt-3 text-sm sm:text-base leading-relaxed text-zinc-600 dark:text-zinc-300">
                                    I began my career as an <strong class="font-semibold text-zinc-900 dark:text-zinc-100">IT Security Manager</strong>, which provided me with a solid foundation in IT infrastructure and security. Over the past 10+ years, I have worked as a Software Engineer, focusing primarily on <strong class="font-semibold text-zinc-900 dark:text-zinc-100">PHP-based</strong> platforms ranging from large-scale e-commerce systems to custom CMS solutions.
                                </p>
                            </div>

                            <!-- Q2 -->
                            <div class="rounded-xl border border-zinc-200/80 bg-white/70 dark:border-zinc-800/80 dark:bg-zinc-900/40 p-6 shadow-sm hover:border-zinc-300 dark:hover:border-zinc-700 transition">
                                <span class="font-mono text-xs font-semibold text-teal-600 dark:text-teal-400 uppercase tracking-wider">02 / Domain & Philosophy</span>
                                <h3 class="mt-1.5 text-base sm:text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                                    Q. Which domain or field are you most confident in?
                                </h3>
                                <p class="mt-3 text-sm sm:text-base leading-relaxed text-zinc-600 dark:text-zinc-300">
                                    Most of the companies I have worked with specialized in digital commerce, allowing me to build deep expertise in the <strong class="font-semibold text-zinc-900 dark:text-zinc-100">E-commerce</strong> domain. Additionally, through my hands-on experience in various startups, I have developed the ability to build infrastructure from the ground up for small-to-medium-sized projects. I believe developers are creators who turn imagination into reality—transforming abstract, ambiguous requirements into reliable, production-ready services, with the ultimate goal of delivering tangible value to real-world businesses.
                                </p>
                            </div>

                            <!-- Q3 -->
                            <div class="rounded-xl border border-zinc-200/80 bg-white/70 dark:border-zinc-800/80 dark:bg-zinc-900/40 p-6 shadow-sm hover:border-zinc-300 dark:hover:border-zinc-700 transition">
                                <span class="font-mono text-xs font-semibold text-teal-600 dark:text-teal-400 uppercase tracking-wider">03 / Modern Stack</span>
                                <h3 class="mt-1.5 text-base sm:text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                                    Q. What is your experience with Node.js?
                                </h3>
                                <p class="mt-3 text-sm sm:text-base leading-relaxed text-zinc-600 dark:text-zinc-300">
                                    I actively follow modern engineering trends and understand the performance benefits of the Node.js ecosystem. While my core experience is in PHP, I have a strong grasp of Node.js fundamentals. Currently, I am contributing to a project building backend services with <strong class="font-semibold text-zinc-900 dark:text-zinc-100">NestJS</strong>. I believe that focusing on core architectural principles rather than just language syntax allows me to adapt quickly and deliver reliable solutions in any stack.
                                </p>
                            </div>

                            <!-- Q4 -->
                            <div class="rounded-xl border border-zinc-200/80 bg-white/70 dark:border-zinc-800/80 dark:bg-zinc-900/40 p-6 shadow-sm hover:border-zinc-300 dark:hover:border-zinc-700 transition">
                                <span class="font-mono text-xs font-semibold text-teal-600 dark:text-teal-400 uppercase tracking-wider">04 / DevOps & Containers</span>
                                <h3 class="mt-1.5 text-base sm:text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                                    Q. How proficient are you with Docker?
                                </h3>
                                <p class="mt-3 text-sm sm:text-base leading-relaxed text-zinc-600 dark:text-zinc-300">
                                    For the past several years, I have consistently used <strong class="font-semibold text-zinc-900 dark:text-zinc-100">Docker and Docker Compose</strong> across all my projects to standardize development environments and eliminate inconsistencies across team members. I am also experienced in containerizing applications and configuring CI/CD workflows. Given my backend background, I am particularly adept at orchestrating <strong class="font-semibold text-zinc-900 dark:text-zinc-100">Nginx, PHP, and MySQL</strong> within containerized environments.
                                </p>
                            </div>

                            <!-- Q5 -->
                            <div class="rounded-xl border border-zinc-200/80 bg-white/70 dark:border-zinc-800/80 dark:bg-zinc-900/40 p-6 shadow-sm hover:border-zinc-300 dark:hover:border-zinc-700 transition">
                                <span class="font-mono text-xs font-semibold text-teal-600 dark:text-teal-400 uppercase tracking-wider">05 / Full-Stack Spectrum</span>
                                <h3 class="mt-1.5 text-base sm:text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                                    Q. Do you prefer frontend or backend development?
                                </h3>
                                <p class="mt-3 text-sm sm:text-base leading-relaxed text-zinc-600 dark:text-zinc-300">
                                    With modern web development blurring the lines between client and server, I value both equally. <strong class="font-semibold text-zinc-900 dark:text-zinc-100">Frontend</strong> development is exciting because of immediate visual feedback and crafting seamless user experiences, while <strong class="font-semibold text-zinc-900 dark:text-zinc-100">backend</strong> engineering is deeply rewarding when designing scalable architectures and optimizing performance. Ultimately, my priority is contributing wherever the product and team need it most.
                                </p>
                            </div>

                            <!-- Q6 -->
                            <div class="rounded-xl border border-zinc-200/80 bg-white/70 dark:border-zinc-800/80 dark:bg-zinc-900/40 p-6 shadow-sm hover:border-zinc-300 dark:hover:border-zinc-700 transition">
                                <span class="font-mono text-xs font-semibold text-teal-600 dark:text-teal-400 uppercase tracking-wider">06 / Infrastructure & Cloud</span>
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

    <script>
        document.getElementById('theme-toggle')?.addEventListener('click', function () {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.theme = isDark ? 'dark' : 'light';
        });
    </script>
</body>

</html>