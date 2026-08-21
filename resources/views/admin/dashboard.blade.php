@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="p-10">
    <h2 class="text-4xl font-bold mb-8 text-gray-800">Welcome to the Admin Dashboard</h2>
    
    <div class="bg-white rounded-xl shadow-lg p-8">
        <p class="text-xl text-gray-700">Select an option from the sidebar to get started.</p>
        <p class="mt-4">You can view all registered schools by clicking on the <a href="{{ route('admin.schools') }}" class="text-blue-600 font-semibold hover:underline">Schools</a> link.</p>

        <div class="mt-8 border-t pt-6">
            <div class="flex items-center space-x-4">
                <a href="{{ route('register') }}" target="_blank" class="inline-block bg-blue-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-700 transition-all duration-200">
                    Register Principal
                </a>
                <a href="{{ route('login') }}" target="_blank" class="inline-block bg-green-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-green-700 transition-all duration-200">
                    Login Principal
                </a>
            </div>
            <p class="mt-2 text-sm text-gray-500">Click a button to open the public registration or login page.</p>
        </div>
    </div>
</div>
@endsection
