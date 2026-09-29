@extends('layouts.app')

@section('title', __('messages.attendance_history'))

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-4xl font-bold mb-6 text-blue-700">{{ __('messages.attendance_history') }}</h1>
    
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

    <!-- Filters -->
    <div class="bg-white p-6 rounded-xl shadow-lg mb-6">
        <form action="{{ route('attendance.history') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.date') }}</label>
                <input type="date" name="date" value="{{ request('date') }}" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.class') }}</label>
                <select name="class" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">{{ __('messages.all_classes') }}</option>
                    @foreach($classes as $class)
                        <option value="{{ $class }}" {{ request('class') == $class ? 'selected' : '' }}>{{ $class }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.division') }}</label>
                <select name="division" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">{{ __('messages.all_divisions') }}</option>
                    @foreach($divisions as $division)
                        <option value="{{ $division }}" {{ request('division') == $division ? 'selected' : '' }}>{{ $division }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-3 flex gap-2">
                <button type="submit" class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition">{{ __('messages.filter') }}</button>
                <a href="{{ route('attendance.history') }}" class="bg-gray-200 text-gray-700 py-2 px-6 rounded-lg hover:bg-gray-300 transition">{{ __('messages.clear') }}</a>
            </div>
        </form>
    </div>

    @if($attendances->isEmpty())
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6">
            {{ __('messages.no_attendance_records') }}
        </div>
    @else
        <div class="grid grid-cols-1 gap-4">
            @foreach($attendances as $attendance)
                <?php
                    $present = 0;
                    $absent = 0;
                    foreach($attendance->students as $student) {
                        if($student['status'] == 'present') {
                            $present++;
                        } else {
                            $absent++;
                        }
                    }
                    $total = count($attendance->students);
                    $formattedDate = date('d F Y', strtotime($attendance->date));
                ?>
                <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-blue-700">{{ $formattedDate }}</h3>
                            <p class="text-gray-600">Class {{ $attendance->class }} - Division {{ $attendance->division }}</p>
                        </div>
                        <div class="flex gap-4 mt-4 md:mt-0">
                            <div class="text-center">
                                <p class="text-sm text-gray-500">{{ __('messages.present') }}</p>
                                <p class="text-2xl font-bold text-green-600">{{ $present }}</p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-500">{{ __('messages.absent') }}</p>
                                <p class="text-2xl font-bold text-red-600">{{ $absent }}</p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-500">{{ __('messages.total_students') }}</p>
                                <p class="text-2xl font-bold text-blue-600">{{ $total }}</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('attendance.view', $attendance->id) }}" class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                            {{ __('messages.view_details') }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
