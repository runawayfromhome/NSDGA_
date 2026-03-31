<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'NSDGA Admin' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen flex text-slate-900">

    <x-admin.sidebar />

    <main class="flex-1 overflow-y-auto">
        <header class="bg-white/80 backdrop-blur-md shadow-sm p-4 flex justify-between ...">
             <h2 class="text-xl font-bold">Accounts Management</h2>
             </header>

        <div class="p-8">
            {{ $slot }} </div>
    </main>

</body>
</html>