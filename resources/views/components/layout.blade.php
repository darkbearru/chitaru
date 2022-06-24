<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <!--link href="/favicon.ico" rel="icon"/-->
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Chita.Ru</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

<x-header/>

<main>
    {{ $slot }}
</main>

<x-footer/>

<script src="{{ asset('/js/flowbite.js') }}"></script>
</body>
</html>
