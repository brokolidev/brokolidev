<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#000000" />
    <link rel="shortcut icon" href="{{ asset('/img/favicon.ico') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">


    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('/img/apple-icon.png') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/creativetimofficial/tailwind-starter-kit/compiled-tailwind.min.css" />

    <!-- Styles -->
    @vite('resources/css/app.css')
    @livewireStyles

    <!-- Scripts -->
    @vite('resources/js/app.js')
</head>

<body class="text-gray-800 antialiased">
    @php
    $isActive = true;
    @endphp
    <header class="pointer-events-none relative z-50 flex flex-col">
        <div class="order-last mt-[calc(theme(spacing.16)-theme(spacing.3))]"></div>
        <div class="top-0 z-10 h-16 pt-6">
            <div class="sm:px-8 top-[var(--header-top,theme(spacing.6))] w-full">
                <div class="mx-auto max-w-7xl lg:px-8">
                    <div class="relative px-4 sm:px-8 lg:px-12">
                        <div class="mx-auto max-w-2xl lg:max-w-5xl">
                            <div class="relative flex gap-4">
                                <div class="flex flex-1 justify-center md:justify-center">
                                    <nav class="pointer-events-auto md:block">
                                        <ul class="flex rounded-full bg-white/90 px-3 text-sm font-medium text-zinc-800 shadow-lg shadow-zinc-800/5 ring-1 ring-zinc-900/5 backdrop-blur dark:bg-zinc-800/90 dark:text-zinc-200 dark:ring-white/10">
                                            <li>
                                                <a @class([ 'text-teal-500 dark:text-teal-400' => request()->is('/'),
                                                    'relative', 'block px-3', 'py-2 transition',
                                                    'hover:text-teal-500', 'dark:hover:text-teal-400'])
                                                    href="/" >About</a>
                                            </li>
                                            <li>
                                                <a @class([ 'dark:text-teal-400 text-teal-500'=> request()->is('articles') || request()->is('articles/*'),
                                                    'relative', 'block px-3', 'py-2 transition',
                                                    'hover:text-teal-500', 'dark:hover:text-teal-400'])
                                                    href="/articles">Articles</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="profile-page">
        @section('contents')
        <section class="relative block" style="height: 500px;">
            <div class="absolute top-0 w-full h-full bg-center bg-cover" style='background-image: url("{{ asset('/img/background.jpg') }}");'>
                <span id="blackOverlay" class="w-full h-full absolute opacity-50 bg-black"></span>
            </div>
            <div class="top-auto bottom-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden" style="height: 70px; transform: translateZ(0px);">
                <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" version="1.1" viewBox="0 0 2560 100" x="0" y="0">
                    <polygon class="text-gray-300 fill-current" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </section>
        <section class="relative py-16 bg-gray-300">
            <div class="container mx-auto px-4">
                <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-xl rounded-lg -mt-64">
                    <div class="px-6">
                        <div class="flex flex-wrap justify-center">
                            <div class="w-full px-4 lg:order-1 flex justify-center">
                                <div class="relative">
                                    <img alt="..." src="{{ asset('/img/profile.png') }}" class="shadow-xl rounded-full h-auto align-middle border-none absolute -m-16" style="max-width: 150px;" />
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-32">
                            <h3 class="text-4xl font-semibold leading-normal mb-2 text-gray-800 mb-2">
                                Hyunseung Choi
                            </h3>
                            <div class="text-sm leading-normal mt-0 mb-2 text-gray-500 font-bold uppercase">
                                <i class="fas fa-map-marker-alt mr-2 text-lg text-gray-500"></i>
                                Calgary, Alberta
                            </div>
                            <div class="mb-2 text-gray-700 mt-10">
                                <i class="fas fa-briefcase mr-2 text-lg text-gray-500"></i>Web Developer
                            </div>
                        </div>
                        <div class="bg-white px-6 py-10 mt-10 lg:px-8 border-t border-gray-300">
                            <div class="mx-auto max-w-3xl text-base leading-7 text-gray-700">
                                <p class="text-base font-semibold leading-7 text-indigo-600">Q. Tell me about your experience</p>
                                <p class="leading-8">
                                    I started my career as an <strong class="font-semibold text-gray-900">IT Security Manager</strong>, where I gained extensive foundational knowledge in IT. Currently, I have been working as a Web Developer for over 10 years. Most of my projects have been <strong class="font-semibold text-gray-900">PHP-based</strong>, ranging from e-commerce to CMS projects.
                                </p>
                                <p class="mt-6 text-base font-semibold leading-7 text-indigo-600">Q. Do you have a field you are most confident in?</p>
                                <p class="leading-8">
                                    Most of the companies I have worked for provided IT-based e-commerce services, so I can say that I have a strong expertise in the <strong class="font-semibold text-gray-900">E-commerce </strong> field. Additionally, having experienced various startups, I have the knowledge and experience to derive requirements and build new infrastructure from scratch for small to medium-sized new projects.
                                </p>
                                <p class="mt-6 text-base font-semibold leading-7 text-indigo-600">Q. How much knowledge do you have about Node.js?</p>
                                <p class="leading-8">
                                    I am aware that many companies are now using Node.js stacks for their projects due to its popularity and performance. While I haven't been using Node.js for a long time, I have a good understanding of its core elements. Currently, I am volunteering on a project that involves backend development based on <strong class="font-semibold text-gray-900">Nest.js</strong> I constantly strive to acquire the necessary knowledge in the rapidly evolving tech landscape. Understanding the core ideas, rather than just the language differences, enables me to effectively handle practical work.
                                </p>
                                <p class="mt-6 text-base font-semibold leading-7 text-indigo-600">Q. How proficient are you with Docker?</p>
                                <p class="leading-8">
                                    For the past few years, all the projects I have worked on have used <strong class="font-semibold text-gray-900">Docker and Docker Compose</strong> to set up the development environment. Docker is an incredibly powerful tool, and I find it especially useful for ensuring that everyone on the team can develop in the same environment. If there is no CI/CD expert in the team familiar with Docker, I can set up that environment for our team. Since I have been a PHP develper for long time, I am accustomed to using <strong class="font-semibold text-gray-900">MySQL and Nginx</strong> for service setup within Docker environments.
                                </p>
                                <p class="mt-6 text-base font-semibold leading-7 text-indigo-600">Q. Do you prefer front-end or back-end work?</p>
                                <p class="leading-8">
                                    Recently, with the wide variety and strength of front-end stacks, I believe it's not meaningful to distinguish between them. <strong class="font-semibold text-gray-900">Front-end</strong> work is enjoyable because you can see the results visually and make adjustments as you go, while <strong class="font-semibold text-gray-900">backend</strong> work is rewarding because it involves optimizing performance. I think what's important is being able to contribute to the team in the areas where it's needed.
                                </p>
                                <p class="mt-6 text-base font-semibold leading-7 text-indigo-600">Q. It sounds like you're quite knowledgeable about servers as well?</p>
                                <p class="leading-8">
                                    In the past, developers were required to have knowledge in various fields such as front-end, back-end, and DevOps, as it was common to be responsible for building up to those areas. I have basic knowledge in these areas, as the need for building up to these areas was not as common. However, with the trend of building services using <strong class="font-semibold text-gray-900">cloud technology</strong>, I have gained experience in configuring infrastructure and integrating CI/CD on platforms such as AWS, Azure, and GCP for less heavy services. Nowadays, there are dedicated infrastructure experts in each team, so effective communication with them is important.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @show
    </main>
    <footer class="relative bg-gray-300 pt-8 pb-6">
        <div class="bottom-auto top-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden -mt-20" style="height: 80px; transform: translateZ(0px);">
            <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" version="1.1" viewBox="0 0 2560 100" x="0" y="0">
                <polygon class="text-gray-300 fill-current" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap">
                <div class="w-full lg:w-6/12 px-4">
                    <h4 class="text-3xl font-semibold">Let's keep in touch!</h4>
                    <h5 class="text-lg mt-0 mb-2 text-gray-700">
                        Find me on any of these platforms, I respond 1-2 business days.
                    </h5>
                    <div class="mt-6" x-data="{}">
                        <button @click="location.href='https://github.com/brokolidev'" class="bg-white text-gray-900 shadow-lg font-normal h-10 w-10 items-center justify-center align-center rounded-full outline-none focus:outline-none mr-2 p-3" type="button">
                            <i class="flex fab fa-github"></i>
                        </button>
                        <button @click="location.href='https://www.linkedin.com/in/brokolidev/'" class="bg-white text-blue-600 shadow-lg font-normal h-10 w-10 items-center justify-center align-center rounded-full outline-none focus:outline-none mr-2 p-3" type="button">
                            <i class="flex fab fa-linkedin"></i></button>
                        <button @click="location.href='https://www.facebook.com/bocalist'" class="bg-white text-blue-600 shadow-lg font-normal h-10 w-10 items-center justify-center align-center rounded-full outline-none focus:outline-none mr-2 p-3" type="button">
                            <i class="flex fab fa-facebook-square"></i></button>
                    </div>
                </div>
            </div>
            <hr class="my-6 border-gray-400" />
            <div class="flex flex-wrap items-center md:justify-between justify-center">
                <div class="w-full md:w-4/12 px-4 mx-auto text-center">
                    <div class="text-sm text-gray-600 font-semibold py-1">
                        Copyright © {{ date('Y') }} brokolidev.com by
                        <a href="mailto:bocalist@gmail.com" class="text-gray-600 hover:text-gray-900">Brokoli</a>.
                    </div>
                </div>
            </div>
        </div>
    </footer>
    @livewireScripts
</body>

</html>