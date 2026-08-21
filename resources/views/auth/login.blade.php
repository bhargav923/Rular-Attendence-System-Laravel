@extends('layouts.auth')

@section('title', 'Principal Login')

@section('content')
<div class="bg-white rounded-2xl shadow-2xl p-8">
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-blue-800 mb-2">આચાર્ય લૉગિન</h1>
        <p class="text-gray-600">Principal Login</p>
    </div>
    
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif
    
    <form method="POST" action="/login" class="space-y-4">
        @csrf
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Email / ઈમેઈલ</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
        </div>
        
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Password / પાસવર્ડ</label>
            <input type="password" name="password" placeholder="Enter your password" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
        </div>
        
        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 text-lg">લૉગિન કરો / Login</button>
    </form>
    
    <div class="mt-6 text-center">
        <p class="text-gray-600">Don't have an account? <a href="/register" class="text-blue-600 hover:text-blue-800 font-semibold">Register here</a></p>
    </div>
</div>
@endsection
