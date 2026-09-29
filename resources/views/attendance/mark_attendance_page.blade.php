@extends('layouts.app')

@section('title', __('messages.mark_attendance'))

@section('content')

<div class="max-w-6xl mx-auto px-4 py-6">

<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-3xl md:text-4xl font-bold text-gray-800">
        {{ __('messages.mark_attendance') }}
    </h1>
    <p class="text-gray-500 mt-1">
        {{ __('messages.record_attendance') }}
    </p>
</div>

<!-- Class Information -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 mb-6">

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

        <div class="bg-blue-50 rounded-xl p-4">
            <p class="text-sm text-gray-500 mb-1">Class</p>
            <p class="text-xl font-bold text-blue-700">
                {{ $class }}
            </p>
        </div>

        <div class="bg-blue-50 rounded-xl p-4">
            <p class="text-sm text-gray-500 mb-1">Division</p>
            <p class="text-xl font-bold text-blue-700">
                {{ $division }}
            </p>
        </div>

        <div class="bg-blue-50 rounded-xl p-4">
            <p class="text-sm text-gray-500 mb-1">Date</p>
            <p class="text-xl font-bold text-blue-700">
                {{ date('Y-m-d') }}
            </p>
        </div>

    </div>

</div>

<!-- Success Message -->
@if(session('success'))

    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6">
        {{ session('success') }}
    </div>

@endif

<!-- Error Message -->
@if(session('error'))

    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6">
        {{ session('error') }}
    </div>

@endif

@if($students->isEmpty())

    <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-4 rounded-xl">
        No students found for Class {{ $class }} - Division {{ $division }}.
    </div>

@else

    <form action="{{ route('attendance.store') }}" method="POST" id="attendanceForm">

        @csrf

        <input type="hidden" name="class" value="{{ $class }}">
        <input type="hidden" name="division" value="{{ $division }}">
        <input type="hidden" name="date" value="{{ date('Y-m-d') }}">

        <!-- Student List -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6">

            <div class="px-5 py-4 border-b border-gray-200">

                <div class="flex items-center justify-between">

                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">
                            {{ __('messages.student_attendance') }}
                        </h2>

                        <p class="text-sm text-gray-500">
                            {{ __('messages.mark_students_present_absent') }}
                        </p>
                    </div>

                    <div class="bg-blue-50 text-blue-700 px-3 py-2 rounded-lg text-sm font-semibold">
                        {{ $students->count() }} {{ __('messages.student_list') }}
                    </div>

                </div>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full min-w-[650px]">

                    <thead class="bg-blue-600 text-white">

                        <tr>

                            <th class="px-5 py-4 text-left text-sm font-semibold">
                                {{ __('messages.roll_no') }}
                            </th>

                            <th class="px-5 py-4 text-left text-sm font-semibold">
                                {{ __('messages.enrollment_no') }}
                            </th>

                            <th class="px-5 py-4 text-left text-sm font-semibold">
                                {{ __('messages.student_name') }}
                            </th>

                            <th class="px-5 py-4 text-center text-sm font-semibold">
                                {{ __('messages.present') }}
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($students as $index => $student)

                            <tr class="border-b border-gray-100 hover:bg-blue-50 transition">

                                <!-- Roll Number -->
                                <td class="px-5 py-4 font-semibold text-gray-700">
                                    {{ $index + 1 }}
                                </td>

                                <!-- Enrollment Number -->
                                <td class="px-5 py-4 text-gray-600">
                                    {{ $student->enrollment_number ?? 'N/A' }}
                                </td>

                                <!-- Student Name -->
                                <td class="px-5 py-4 font-medium text-gray-800">
                                    {{ $student->name }}
                                </td>

                                <!-- Attendance -->
                                <td class="px-5 py-4 text-center">

                                    <input
                                        type="checkbox"
                                        name="students[{{ $index }}][attendance]"
                                        value="present"
                                        class="student-checkbox w-5 h-5 text-blue-600 rounded focus:ring-blue-500 cursor-pointer"
                                        checked
                                    >

                                    <input
                                        type="hidden"
                                        name="students[{{ $index }}][enrollment_number]"
                                        value="{{ $student->enrollment_number ?? '' }}"
                                    >

                                    <input
                                        type="hidden"
                                        name="students[{{ $index }}][name]"
                                        value="{{ $student->name }}"
                                    >

                                    <input
                                        type="hidden"
                                        name="students[{{ $index }}][status]"
                                        value="present"
                                        class="status-field"
                                    >

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

        <!-- Attendance Count -->
        <div class="flex justify-center mb-5">

            <div class="bg-gray-50 border border-gray-200 rounded-xl px-6 py-3 flex items-center gap-6 text-sm">

                <div>
                    <span class="text-gray-500">{{ __('messages.present') }}</span>
                    <span id="presentCount" class="font-bold text-green-600 ml-1">
                        {{ $students->count() }}
                    </span>
                </div>

                <div class="h-5 w-px bg-gray-300"></div>

                <div>
                    <span class="text-gray-500">{{ __('messages.absent') }}</span>
                    <span id="absentCount" class="font-bold text-red-600 ml-1">
                        0
                    </span>
                </div>

            </div>

        </div>

        <!-- Save Button -->
        <div class="flex justify-center">

            <button
                type="submit"
                class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-xl font-semibold shadow-sm transition"
            >
                {{ __('messages.save_attendance') }}
            </button>

        </div>

    </form>

@endif

</div>

<script>

    const checkboxes = document.querySelectorAll('.student-checkbox');
    const statusFields = document.querySelectorAll('.status-field');
    const presentCount = document.getElementById('presentCount');
    const absentCount = document.getElementById('absentCount');

    function updateAttendance() {

        let present = 0;

        checkboxes.forEach((checkbox, index) => {

            if (checkbox.checked) {

                present++;

                statusFields[index].value = 'present';

            } else {

                statusFields[index].value = 'absent';

            }

        });

        const total = checkboxes.length;
        const absent = total - present;

        presentCount.textContent = present;
        absentCount.textContent = absent;

    }

    checkboxes.forEach((checkbox) => {

        checkbox.addEventListener('change', updateAttendance);

    });

    updateAttendance();

</script>

@endsection
