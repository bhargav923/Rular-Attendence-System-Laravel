@extends('layouts.app')

@section('title', __('messages.attendance_details'))

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-4xl font-bold text-blue-700">{{ __('messages.attendance_details') }}</h1>
        <a href="{{ route('attendance.history') }}" class="bg-gray-200 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-300 transition">
            {{ __('messages.back_to_history') }}
        </a>
    </div>
    
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white p-6 rounded-xl shadow-lg mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.date') }}</label>
                <p class="text-xl font-semibold text-blue-700">{{ date('d F Y', strtotime($attendance->date)) }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.class_division') }}</label>
                <p class="text-xl font-semibold text-blue-700">{{ __('messages.class') }} {{ $attendance->class }} - {{ __('messages.division') }} {{ $attendance->division }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
        <table class="w-full">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="p-4 text-left">{{ __('messages.roll_no') }}</th>
                    <th class="p-4 text-left">{{ __('messages.enrollment_no') }}</th>
                    <th class="p-4 text-left">{{ __('messages.student_name') }}</th>
                    <th class="p-4 text-center">{{ __('messages.status') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendance->students as $index => $student)
                    <tr class="border-b {{ $index % 2 === 0 ? 'bg-gray-50' : 'bg-white' }}">
                        <td class="p-4">{{ $student['roll_number'] ?? 'N/A' }}</td>
                        <td class="p-4">{{ $student['enrollment_number'] }}</td>
                        <td class="p-4">{{ $student['student_name'] }}</td>
                        <td class="p-4 text-center">
                            @if($student['status'] == 'present')
                                <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-sm font-semibold">{{ __('messages.present') }}</span>
                            @else
                                <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-sm font-semibold">{{ __('messages.absent') }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

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
    ?>

    <div class="bg-blue-50 p-6 rounded-xl shadow-lg">
        <div class="grid grid-cols-3 gap-4 text-center">
            <div>
                <p class="text-sm text-gray-600">Present</p>
                <p class="text-3xl font-bold text-green-600">{{ $present }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Absent</p>
                <p class="text-3xl font-bold text-red-600">{{ $absent }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Total Students</p>
                <p class="text-3xl font-bold text-blue-600">{{ $total }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
