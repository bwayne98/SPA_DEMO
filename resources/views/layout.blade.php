<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link
      href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet"
    />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
</head>

<body class="bg-sky-800 bg-opacity-10" style="overflow-x:hidden">

    <div id="app">
        @yield("app")
    </div>
</body>

<script src="{{ mix('/js/app.js') }}"></script>
<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBYq2MyVl-xGx9XlCJRA0xNTH9a8C4Un8I&callback=initMap">
</script>

</html>