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
                    Copyright © 2023 brokolidev.com by
                    <a
                        href="mailto:bocalist@gmail.com"
                        class="text-gray-600 hover:text-gray-900"
                    >Ted</a>.
                </div>
            </div>
        </div>
    </div>
</footer>
