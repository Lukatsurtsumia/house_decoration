@props(['content'])
<!DOCTYPE html>
<html lang="ka">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#ffffff">

        <title>{{ $content['brand']['name'] }} | {{ $content['brand']['tagline'] }}</title>
        <meta name="description" content="{{ $content['hero']['description'] }}">

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-paper text-ink antialiased">
        {{ $slot }}
    </body>
</html>
