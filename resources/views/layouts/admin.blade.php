<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-blue-800 text-white p-6 fixed h-full">
        <h1 class="text-2xl font-bold mb-6">Admin Panel</h1>
        <nav class="flex flex-col gap-4 text-lg">
            <a href="{{ route('admin.dashboard') }}" class="p-3 rounded-lg hover:bg-blue-700 transition font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-blue-900' : '' }}">Dashboard</a>
            <a href="{{ route('admin.schools') }}" class="p-3 rounded-lg hover:bg-blue-700 transition font-semibold {{ request()->routeIs('admin.schools') ? 'bg-blue-900' : '' }}">Schools</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 ml-64">
        @yield('content')
    </main>

</body>
</html>
