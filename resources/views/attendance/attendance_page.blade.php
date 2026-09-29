@extends('layouts.app')

@section('title', __('messages.attendance'))

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-4xl font-bold mb-8 text-blue-700">{{ __('messages.attendance_dashboard') }}</h1>
    
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    @if(empty($classGroups))
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6">
            No students found. Please register students first.
        </div>
    @else
        <div class="space-y-6">
            @foreach($classGroups as $classGroup)
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                    <!-- Class Header -->
                    <div class="bg-blue-600 text-white p-4">
                        <h2 class="text-2xl font-bold">{{ __('messages.class') }} {{ $classGroup['class'] }}</h2>
                    </div>
                    
                    <!-- Divisions List -->
                    <div class="p-4 space-y-2">
                        @foreach($classGroup['divisions'] as $division)
                            <a href="{{ route('attendance.mark', ['class' => $classGroup['class'], 'division' => $division['division']]) }}" 
                               class="block bg-gray-50 hover:bg-blue-50 border border-gray-200 hover:border-blue-300 rounded-lg p-4 transition-all duration-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <span class="text-blue-600 mr-2">→</span>
                                        <p class="text-xl font-semibold text-gray-800">{{ __('messages.division') }} {{ $division['division'] }}</p>
                                    </div>
                                    <div class="bg-blue-100 rounded-lg py-1 px-3 text-center">
                                        <p class="text-xs text-gray-600">{{ __('messages.student_list') }}</p>
                                        <p class="text-lg font-bold text-blue-700">{{ $division['count'] }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
