<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ $title ?? config('app.name', 'Algebra Blog') }}</title>

<!-- Scripts -->
@vite(['resources/css/app.css', 'resources/js/app.js'])