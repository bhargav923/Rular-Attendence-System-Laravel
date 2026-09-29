@extends('layouts.app')

@section('content')
<div class="bg-white shadow-lg rounded-xl p-8 max-w-2xl mx-auto">
    <div class="flex justify-between items-center border-b pb-4 mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Student Details</h2>
        <a href="{{ route('students.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Back to List</a>
    </div>
        <div class="flex justify-center mb-6">
        <div class="w-40 h-40 rounded-full bg-gray-200 border-4 border-gray-300 overflow-hidden">
            @if($student->image)
                <img src="{{ asset($student->image) }}" alt="Student Photo" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-500">No Photo</div>
            @endif
        </div>
    </div>
    <div class="space-y-4 text-lg text-gray-700">
        <p><strong>Name:</strong> {{ $student->name }}</p>
        <p><strong>Class:</strong> {{ $student->class }}</p>
        <p><strong>Division:</strong> {{ $student->division }}</p>
        <p><strong>Age:</strong> {{ $student->age }}</p>
        <p><strong>Aadhar:</strong> XXXX XXXX {{ substr($student->aadhar, -4) }}</p>
        <p><strong>Village:</strong> {{ $student->village }}</p>
        <p><strong>Date of Birth:</strong> {{ $student->dob }}</p>
    </div>
</div>
@endsection
