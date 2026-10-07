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
                            <h3 class="text-4xl font-semibold leading-normal mb-2 text-gray-800">
                                Ted Choi
                            </h3>
                            <div class="text-sm leading-normal mt-0 mb-2 text-gray-500 font-bold uppercase">
                                <i class="fas fa-map-marker-alt mr-2 text-lg text-gray-500"></i>
                                Calgary, Alberta
                            </div>
                            <div class="mb-2 text-gray-700 mt-10">
                                <i class="fas fa-briefcase mr-2 text-lg text-gray-500"></i>Software Engineer
                            </div>
                        </div>
                        <div class="bg-white px-6 py-10 mt-10 lg:px-8 border-t border-gray-300">
                            <div class="mx-auto max-w-3xl text-base leading-7 text-gray-700">
                                <p class="text-base font-semibold leading-7 text-indigo-600">Q. Tell me about your background and experience.</p>
                                <p class="leading-8">
                                    I began my career as an <strong class="font-semibold text-gray-900">IT Security Manager</strong>, which provided me with a solid foundation in IT infrastructure and security. Over the past 10+ years, I have worked as a Software Engineer, focusing primarily on <strong class="font-semibold text-gray-900">PHP-based</strong> platforms ranging from large-scale e-commerce systems to custom CMS solutions.
                                </p>
                                <p class="mt-6 text-base font-semibold leading-7 text-indigo-600">Q. Which domain or field are you most confident in?</p>
                                <p class="leading-8">
                                    Most of the companies I have worked with specialized in digital commerce, allowing me to build deep expertise in the <strong class="font-semibold text-gray-900">E-commerce</strong> domain. Additionally, through my hands-on experience in various startups, I have developed the ability to translate business requirements into technical solutions and build infrastructure from the ground up for small-to-medium-sized projects.
                                </p>
                                <p class="mt-6 text-base font-semibold leading-7 text-indigo-600">Q. What is your experience with Node.js?</p>
                                <p class="leading-8">
                                    I actively follow modern engineering trends and understand the performance benefits of the Node.js ecosystem. While my core experience is in PHP, I have a strong grasp of Node.js fundamentals. Currently, I am contributing to a project building backend services with <strong class="font-semibold text-gray-900">NestJS</strong>. I believe that focusing on core architectural principles rather than just language syntax allows me to adapt quickly and deliver reliable solutions in any stack.
                                </p>
                                <p class="mt-6 text-base font-semibold leading-7 text-indigo-600">Q. How proficient are you with Docker?</p>
                                <p class="leading-8">
                                    For the past several years, I have consistently used <strong class="font-semibold text-gray-900">Docker and Docker Compose</strong> across all my projects to standardize development environments and eliminate inconsistencies across team members. I am also experienced in containerizing applications and configuring CI/CD workflows. Given my backend background, I am particularly adept at orchestrating <strong class="font-semibold text-gray-900">Nginx, PHP, and MySQL</strong> within containerized environments.
                                </p>
                                <p class="mt-6 text-base font-semibold leading-7 text-indigo-600">Q. Do you prefer frontend or backend development?</p>
                                <p class="leading-8">
                                    With modern web development blurring the lines between client and server, I value both equally. <strong class="font-semibold text-gray-900">Frontend</strong> development is exciting because of immediate visual feedback and crafting seamless user experiences, while <strong class="font-semibold text-gray-900">backend</strong> engineering is deeply rewarding when designing scalable architectures and optimizing performance. Ultimately, my priority is contributing wherever the product and team need it most.
                                </p>
                                <p class="mt-6 text-base font-semibold leading-7 text-indigo-600">Q. How experienced are you with server and cloud infrastructure?</p>
                                <p class="leading-8">
                                    Having worked in environments where full-cycle ownership was essential, I naturally developed strong capabilities in server administration and DevOps. With the widespread adoption of <strong class="font-semibold text-gray-900">cloud platforms</strong>, I have gained practical experience architecting infrastructure and establishing automated CI/CD pipelines across AWS, Azure, and GCP. While many organizations now have dedicated infrastructure specialists, my practical knowledge allows me to collaborate effectively and bridge the gap between development and operations.
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
                        Connect with me on any of these platforms; I typically respond within 1–2 business days.
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