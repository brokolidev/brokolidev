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

    <link
        rel="apple-touch-icon"
        sizes="76x76"
        href="{{ asset('/img/apple-icon.png') }}"
    />
    <link
        rel="stylesheet"
        href="./vendor/@fortawesome/fontawesome-free/css/all.min.css"
    />

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/gh/creativetimofficial/tailwind-starter-kit/compiled-tailwind.min.css"
    />

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body class="text-gray-800 antialiased">
<nav class="top-0 absolute z-50 w-full flex flex-wrap items-center justify-between px-2 py-3 navbar-expand-lg">
    <div class="container px-4 mx-auto flex flex-wrap items-center justify-between">
        <div class="w-full relative flex justify-between lg:w-auto lg:static lg:block lg:justify-start">
            <a class="text-sm font-bold leading-relaxed inline-block mr-4 py-2 whitespace-no-wrap uppercase text-white"
               href="/">BROKOLIDEV</a>
        </div>
    </div>
</nav>
<main class="profile-page">
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
                                    src="{{ asset('/img/profile.jpg') }}"
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
                            Brokoli
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
                                    information security and IT-based service industry. Skilled in PHP, Laravel, Python,
                                    jQuery, VueJS, MySQL and Linux. Strong professional with a Bachelor focused in
                                    Information Security and Web Development from Seoul Digital University. Recently I
                                    am working on developing mobile apps on IOS platform with Swift and SwiftUI.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
                    Find me on any of these platforms, we respond 1-2 business days.
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
                    Copyright © 2020 brokolidev.com by
                    <a
                        href="mailto:bocalist@gmail.com"
                        class="text-gray-600 hover:text-gray-900"
                    >Brokoli</a>.
                </div>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
