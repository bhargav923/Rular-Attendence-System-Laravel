<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Rural Attendance System')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts Gujarati -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Gujarati&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Noto Sans Gujarati', sans-serif; }
    </style>
    @yield('styles')
</head>
<body class="flex min-h-screen bg-gray-100">

    <!-- Sidebar -->
    <aside id="sidebar" class="w-64 bg-blue-800 text-white p-6 flex flex-col fixed h-full transform -translate-x-full md:translate-x-0 transition-transform duration-300">
        <h1 class="text-3xl font-bold mb-8">@lang('messages.welcome')</h1>
        <nav class="flex flex-col gap-4 text-lg">
            <a href="{{ url('/') }}" class="py-2 px-4 rounded hover:bg-blue-600 transition font-semibold {{ request()->is('/') ? 'bg-blue-700' : '' }}">@lang('messages.home')</a>
            <a href="{{ url('/student/register') }}" class="py-2 px-4 rounded hover:bg-blue-600 transition font-semibold {{ request()->is('student/register') ? 'bg-blue-700' : '' }}">@lang('messages.student_register')</a>
            <a href="{{ url('/students') }}" class="py-2 px-4 rounded hover:bg-blue-600 transition font-semibold {{ request()->is('students') ? 'bg-blue-700' : '' }}">@lang('messages.student_list')</a>
        </nav>

        <div class="mt-auto">
            <label for="language-switcher" class="block text-sm font-medium text-white">@lang('messages.language')</label>
            <select id="language-switcher" name="language" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md text-gray-800">
                <option value="gu" {{ app()->getLocale() == 'gu' ? 'selected' : '' }}>ગુજરાતી</option>
                <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
                <option value="hi" {{ app()->getLocale() == 'hi' ? 'selected' : '' }}>हिन्दी</option>
                <option value="mr" {{ app()->getLocale() == 'mr' ? 'selected' : '' }}>मराठी</option>
                <option value="ta" {{ app()->getLocale() == 'ta' ? 'selected' : '' }}>தமிழ்</option>
                <option value="te" {{ app()->getLocale() == 'te' ? 'selected' : '' }}>తెలుగు</option>
                <option value="kn" {{ app()->getLocale() == 'kn' ? 'selected' : '' }}>ಕನ್ನಡ</option>
                <option value="ml" {{ app()->getLocale() == 'ml' ? 'selected' : '' }}>മലയാളം</option>
                <option value="bn" {{ app()->getLocale() == 'bn' ? 'selected' : '' }}>বাংলা</option>
                <option value="as" {{ app()->getLocale() == 'as' ? 'selected' : '' }}>অসমীয়া</option>
                <option value="pa" {{ app()->getLocale() == 'pa' ? 'selected' : '' }}>ਪੰਜਾਬੀ</option>
            </select>
        </div>
    </aside>

    <!-- Mobile Menu Button -->
    <button id="menu-btn" class="md:hidden fixed top-4 left-4 bg-blue-800 text-white p-2 rounded z-50">☰</button>

    <!-- Main Content -->
    <main class="flex-1 p-10 md:ml-64 pt-20 md:pt-10">
        @yield('content')
    </main>

    <script>
        const menuBtn = document.getElementById('menu-btn');
        const sidebar = document.getElementById('sidebar');
        menuBtn.addEventListener('click', () => sidebar.classList.toggle('-translate-x-full'));

        document.getElementById('language-switcher').addEventListener('change', function () {
            window.location.href = '/language/' + this.value;
        });
    </script>
</body>
</html>
