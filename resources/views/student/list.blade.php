@extends('layouts.app')

@section('content')
<h2 class="text-3xl font-bold mb-6">{{ __('messages.student_list') }}</h2>

<table class="w-full border-collapse bg-white shadow-lg rounded-xl">
    <thead>
        <tr class="bg-blue-600 text-white">
            <th class="p-3">{{ __('messages.name') }}</th>
            <th class="p-3">{{ __('messages.class') }}</th>
            <th class="p-3">{{ __('messages.division') }}</th>
            <th class="p-3">{{ __('messages.age') }}</th>
            <th class="p-3">{{ __('messages.aadhar_no') }}</th>
            <th class="p-3">{{ __('messages.village') }}</th>
            <th class="p-3">{{ __('messages.date_of_birth') }}</th>
            <th class="p-3">{{ __('messages.actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $student)
        <tr class="border-b text-center">
            <td class="p-3">{{ $student->name }}</td>
            <td class="p-3">{{ $student->class }}</td>
            <td class="p-3">{{ $student->division }}</td>
            <td class="p-3">{{ $student->age }}</td>
            <td class="p-3">{{ $student->aadhar }}</td>
            <td class="p-3">{{ $student->village }}</td>
            <td class="p-3">{{ $student->dob }}</td>
            <td class="p-3">
                <a href="{{ route('student.show', $student->id) }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">
                    {{ __('messages.details') }}
                </a>
                <a href="{{ route('student.idcard', $student->id) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 ml-2">
                    {{ __('messages.id_card') }}
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
