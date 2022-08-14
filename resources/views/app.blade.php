<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @livewireStyles
    @vite('resources/css/app.css')
</head>
<body class="bg-slate-100">
@livewire('main-navigation')
<div class="p-6">
@yield('content')
</div>
@livewireScripts
</body>
</html>
