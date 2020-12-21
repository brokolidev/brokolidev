<!doctype html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Memory Game</title>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body>
    <div x-data="{}" class="px-10 flex items-center justify-center min-h-screen">
        <div class="flex-1 grid grid-cols-4 gap-10">
            <div class="h-32 bg-gray-300">
                <button @click="alert('test')">Click Me</button>
            </div>
            <div class="h-32 bg-gray-300">FOO</div>
            <div class="h-32 bg-gray-300">FOO</div>
            <div class="h-32 bg-gray-300">FOO</div>
            <div class="h-32 bg-gray-300">FOO</div>
            <div class="h-32 bg-gray-300">FOO</div>
            <div class="h-32 bg-gray-300">FOO</div>
            <div class="h-32 bg-gray-300">FOO</div>
        </div>
    </div>
</body>
</html>
