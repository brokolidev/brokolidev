<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#000000"/>
    <link rel="shortcut icon" href="{{ asset('/img/favicon.ico') }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">


    <link
        rel="apple-touch-icon"
        sizes="76x76"
        href="{{ asset('/img/apple-icon.png') }}"
    />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    />

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/gh/creativetimofficial/tailwind-starter-kit/compiled-tailwind.min.css"
    />

    <!-- Styles -->
    @vite('resources/css/app.css')
    @livewireStyles

    <!-- Scripts -->
    @vite('resources/js/app.js')
</head>
<body class="text-gray-800 antialiased">

<header class="pointer-events-none relative z-50 flex flex-col">
    <div class="order-last mt-[calc(theme(spacing.16)-theme(spacing.3))]"></div>
    <div class="top-0 z-10 h-16 pt-6">
        <div class="sm:px-8 top-[var(--header-top,theme(spacing.6))] w-full">
            <div class="mx-auto max-w-7xl lg:px-8">
                <div class="relative px-4 sm:px-8 lg:px-12">
                    <div class="mx-auto max-w-2xl lg:max-w-5xl">
                        <div class="relative flex gap-4">
                            <div class="flex flex-1"></div>
                            <div class="flex flex-1 justify-end md:justify-center">
                                <div class="pointer-events-auto md:hidden">
                                    <button
                                        class="group flex items-center rounded-full bg-white/90 px-4 py-2 text-sm font-medium text-zinc-800 shadow-lg shadow-zinc-800/5 ring-1 ring-zinc-900/5 backdrop-blur dark:bg-zinc-800/90 dark:text-zinc-200 dark:ring-white/10 dark:hover:ring-white/20"
                                        id="headlessui-popover-button-:Rqb6:" type="button" aria-expanded="false"
                                        data-headlessui-state="">Menu
                                        <svg viewBox="0 0 8 6" aria-hidden="true"
                                             class="ml-3 h-auto w-2 stroke-zinc-500 group-hover:stroke-zinc-700 dark:group-hover:stroke-zinc-400">
                                            <path d="M1.75 1.75 4 4.25l2.25-2.5" fill="none" stroke-width="1.5"
                                                  stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                </div>
                                <nav class="pointer-events-auto hidden md:block">
                                    <ul class="flex rounded-full bg-white/90 px-3 text-sm font-medium text-zinc-800 shadow-lg shadow-zinc-800/5 ring-1 ring-zinc-900/5 backdrop-blur dark:bg-zinc-800/90 dark:text-zinc-200 dark:ring-white/10">
                                        <li>
                                            <a class="relative block px-3 py-2 transition hover:text-teal-500 dark:hover:text-teal-400"
                                               href="/">About</a></li>
                                        <li>
                                            <a class="relative block px-3 py-2 transition hover:text-teal-500 dark:hover:text-teal-400"
                                               href="/articles">Articles</a></li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="flex justify-end md:flex-1">
                                <div class="pointer-events-auto">
                                    <button type="button" aria-label="Toggle dark mode"
                                            class="group rounded-full bg-white/90 px-3 py-2 shadow-lg shadow-zinc-800/5 ring-1 ring-zinc-900/5 backdrop-blur transition dark:bg-zinc-800/90 dark:ring-white/10 dark:hover:ring-white/20">
                                        <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round"
                                             stroke-linejoin="round" aria-hidden="true"
                                             class="h-6 w-6 fill-zinc-100 stroke-zinc-500 transition group-hover:fill-zinc-200 group-hover:stroke-zinc-700 dark:hidden [@media(prefers-color-scheme:dark)]:fill-teal-50 [@media(prefers-color-scheme:dark)]:stroke-teal-500 [@media(prefers-color-scheme:dark)]:group-hover:fill-teal-50 [@media(prefers-color-scheme:dark)]:group-hover:stroke-teal-600">
                                            <path
                                                d="M8 12.25A4.25 4.25 0 0 1 12.25 8v0a4.25 4.25 0 0 1 4.25 4.25v0a4.25 4.25 0 0 1-4.25 4.25v0A4.25 4.25 0 0 1 8 12.25v0Z"></path>
                                            <path
                                                d="M12.25 3v1.5M21.5 12.25H20M18.791 18.791l-1.06-1.06M18.791 5.709l-1.06 1.06M12.25 20v1.5M4.5 12.25H3M6.77 6.77 5.709 5.709M6.77 17.73l-1.061 1.061"
                                                fill="none"></path>
                                        </svg>
                                        <svg viewBox="0 0 24 24" aria-hidden="true"
                                             class="hidden h-6 w-6 fill-zinc-700 stroke-zinc-500 transition dark:block [@media(prefers-color-scheme:dark)]:group-hover:stroke-zinc-400 [@media_not_(prefers-color-scheme:dark)]:fill-teal-400/10 [@media_not_(prefers-color-scheme:dark)]:stroke-teal-500">
                                            <path
                                                d="M17.25 16.22a6.937 6.937 0 0 1-9.47-9.47 7.451 7.451 0 1 0 9.47 9.47ZM12.75 7C17 7 17 2.75 17 2.75S17 7 21.25 7C17 7 17 11.25 17 11.25S17 7 12.75 7Z"
                                                stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                </div>
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
            <div
                class="absolute top-0 w-full h-full bg-center bg-cover"
                style='background-image: url("{{ asset('/img/background.jpg') }}");'
            >
          <span
              id="blackOverlay"
              class="w-full h-full absolute opacity-50 bg-black"
          ></span>
            </div>
            <div
                class="top-auto bottom-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden"
                style="height: 70px; transform: translateZ(0px);"
            >
                <svg
                    class="absolute bottom-0 overflow-hidden"
                    xmlns="http://www.w3.org/2000/svg"
                    preserveAspectRatio="none"
                    version="1.1"
                    viewBox="0 0 2560 100"
                    x="0"
                    y="0"
                >
                    <polygon
                        class="text-gray-300 fill-current"
                        points="2560 0 2560 100 0 100"
                    ></polygon>
                </svg>
            </div>
        </section>
        <section class="relative py-16 bg-gray-300">
            <div class="container mx-auto px-4">
                <div
                    class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-xl rounded-lg -mt-64"
                >
                    <div class="px-6">
                        <div class="flex flex-wrap justify-center">
                            <div
                                class="w-full px-4 lg:order-1 flex justify-center"
                            >
                                <div class="relative">
                                    <img
                                        alt="..."
                                        src="{{ asset('/img/profile.png') }}"
                                        class="shadow-xl rounded-full h-auto align-middle border-none absolute -m-16"
                                        style="max-width: 150px;"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-32">
                            <h3
                                class="text-4xl font-semibold leading-normal mb-2 text-gray-800 mb-2"
                            >
                                Hyunseung Choi
                            </h3>
                            <div
                                class="text-sm leading-normal mt-0 mb-2 text-gray-500 font-bold uppercase"
                            >
                                <i
                                    class="fas fa-map-marker-alt mr-2 text-lg text-gray-500"
                                ></i>
                                Seoul, South Korea
                            </div>
                            <div class="mb-2 text-gray-700 mt-10">
                                <i class="fas fa-briefcase mr-2 text-lg text-gray-500"></i
                                >Full Stack Developer - in Marketboro .inc
                            </div>
                        </div>
                        <div class="mt-10 py-10 border-t border-gray-300 text-center">
                            <div class="flex flex-wrap justify-center">
                                <div class="w-full lg:w-9/12 px-4">
                                    <p class="mb-4 text-lg leading-relaxed text-gray-800">
                                        Experienced developer with a demonstrated history of working in the personal
                                        information security and IT-based service industry. Skilled in PHP, Laravel,
                                        Python,
                                        jQuery, VueJS, MySQL and Linux. Strong professional with a Bachelor focused in
                                        Information Security and Web Development from Seoul Digital University. Recently
                                        I
                                        am working on developing mobile apps on IOS platform with Swift and SwiftUI.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @show
</main>
<footer class="relative bg-gray-300 pt-8 pb-6">
    <div
        class="bottom-auto top-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden -mt-20"
        style="height: 80px; transform: translateZ(0px);"
    >
        <svg
            class="absolute bottom-0 overflow-hidden"
            xmlns="http://www.w3.org/2000/svg"
            preserveAspectRatio="none"
            version="1.1"
            viewBox="0 0 2560 100"
            x="0"
            y="0"
        >
            <polygon
                class="text-gray-300 fill-current"
                points="2560 0 2560 100 0 100"
            ></polygon>
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
                    <button
                        @click="location.href='https://github.com/brokolidev'"
                        class="bg-white text-gray-900 shadow-lg font-normal h-10 w-10 items-center justify-center align-center rounded-full outline-none focus:outline-none mr-2 p-3"
                        type="button"
                    >
                        <i class="flex fab fa-github"></i>
                    </button>
                    <button
                        @click="location.href='https://www.linkedin.com/in/brokolidev/'"
                        class="bg-white text-blue-600 shadow-lg font-normal h-10 w-10 items-center justify-center align-center rounded-full outline-none focus:outline-none mr-2 p-3"
                        type="button"
                    >
                        <i class="flex fab fa-linkedin"></i></button>
                    <button
                        @click="location.href='https://www.facebook.com/bocalist'"
                        class="bg-white text-blue-600 shadow-lg font-normal h-10 w-10 items-center justify-center align-center rounded-full outline-none focus:outline-none mr-2 p-3"
                        type="button"
                    >
                        <i class="flex fab fa-facebook-square"></i></button>
                </div>
            </div>
        </div>
        <hr class="my-6 border-gray-400"/>
        <div
            class="flex flex-wrap items-center md:justify-between justify-center"
        >
            <div class="w-full md:w-4/12 px-4 mx-auto text-center">
                <div class="text-sm text-gray-600 font-semibold py-1">
                    Copyright © 2022 brokolidev.com by
                    <a
                        href="mailto:bocalist@gmail.com"
                        class="text-gray-600 hover:text-gray-900"
                    >Brokoli</a>.
                </div>
            </div>
        </div>
    </div>
</footer>
@livewireScripts
</body>
</html>
