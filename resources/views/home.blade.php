@extends('layouts.app')

@section('title', 'Home')

@section('content')
<section class="bg-gradient-to-r from-blue-400 to-teal-400 text-white rounded-xl p-16 mb-16 text-center">
    <h2 class="text-5xl font-bold mb-6">{{ __('messages.manage_attendance_easily') }}</h2>
    <p class="text-2xl mb-8">{{ __('messages.system_makes_attendance_easy') }}</p>
    <a href="{{ url('/student/register') }}" class="bg-yellow-400 text-gray-900 py-3 px-8 rounded-lg text-2xl font-semibold hover:bg-yellow-300 transition">{{ __('messages.register_now') }}</a>
    <a href="{{ url('/students') }}" class="ml-4 bg-green-400 text-white py-3 px-8 rounded-lg text-2xl font-semibold hover:bg-green-300 transition">{{ __('messages.view_student_list') }}</a>
</section>

<section class="grid grid-cols-1 md:grid-cols-3 gap-8">
    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition text-center">
        <h3 class="text-3xl font-bold mb-4 text-blue-700">{{ __('messages.simple_registration') }}</h3>
        <p class="text-xl text-gray-700">{{ __('messages.students_can_register_quickly') }}</p>
    </div>
    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition text-center">
        <h3 class="text-3xl font-bold mb-4 text-blue-700">{{ __('messages.qr_attendance') }}</h3>
        <p class="text-xl text-gray-700">{{ __('messages.attendance_by_qr_scan') }}</p>
    </div>
    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition text-center">
        <h3 class="text-3xl font-bold mb-4 text-blue-700">{{ __('messages.reports') }}</h3>
        <p class="text-xl text-gray-700">{{ __('messages.get_reports_easily') }}</p>
    </div>
</section>
@endsection
