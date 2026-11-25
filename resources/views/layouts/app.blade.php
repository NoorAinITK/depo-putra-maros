<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('depo.nama'))</title>
    <link rel="stylesheet" href="{{ asset('css/depo.css') }}">
</head>
<body>
<div class="app">
    @hasSection('heading')
        <header class="topbar">
            @hasSection('back')<a class="back" href="@yield('back')">&larr;</a>@endif
            <h1>@yield('heading')</h1>
        </header>
    @endif

    <main class="content">
        @if(session('success'))<div class="alert ok">{{ session('success') }}</div>@endif
        @if($errors->any())
            <div class="alert err"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif

        @yield('content')
    </main>

    @auth
        @include('partials.nav')
    @endauth
</div>
<script src="{{ asset('js/depo.js') }}"></script>
</body>
</html>
