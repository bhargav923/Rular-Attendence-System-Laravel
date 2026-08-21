@extends('layouts.auth')

@section('title', 'School Registration')

@section('content')
<div class="bg-white rounded-2xl shadow-2xl p-8">
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-blue-800 mb-2">શાળા નોંધણી</h1>
        <p class="text-gray-600">School Registration</p>
    </div>
    
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form method="POST" action="/register" class="space-y-4">
        @csrf
        <div>
            <label class="block text-gray-700 font-semibold mb-2">School Name / શાળાનું નામ</label>
            <input type="text" name="school_name" value="{{ old('school_name') }}" placeholder="Enter school name" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
        </div>
        
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Principal Name / આચાર્યનું નામ</label>
            <input type="text" name="principal_name" value="{{ old('principal_name') }}" placeholder="Enter principal name" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
        </div>
        
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Email / ઈમેઈલ</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter email address" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
        </div>
        
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Password / પાસવર્ડ</label>
            <input type="password" name="password" placeholder="Enter password (min 6 characters)" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
        </div>
        
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Address / સરનામું</label>
            <input type="text" name="address" value="{{ old('address') }}" placeholder="Enter school address" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
        </div>
        
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Phone / ફોન નંબર</label>
            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Enter phone number" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
        </div>
        
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 text-lg">નોંધણી કરો / Register</button>
    </form>
    
    <div class="mt-6 text-center">
        <p class="text-gray-600">Already registered? <a href="/login" class="text-blue-600 hover:text-blue-800 font-semibold">Login here</a></p>
    </div>
</div>
@endsection
