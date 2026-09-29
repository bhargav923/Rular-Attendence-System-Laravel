@extends('layouts.admin')

@section('title', 'School Details')

@section('content')
<div class="p-10">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-4xl font-bold text-gray-800">School Details</h2>
        <a href="{{ route('admin.schools') }}" class="bg-gray-200 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-300 transition">
            Back to Schools
        </a>
    </div>
    
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">School Name</label>
                <p class="text-xl font-semibold text-gray-800">{{ $school->school_name }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Principal Name</label>
                <p class="text-xl font-semibold text-gray-800">{{ $school->principal_name }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                <p class="text-xl font-semibold text-blue-600">{{ $school->email }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Phone</label>
                <p class="text-xl font-semibold text-gray-800">{{ $school->phone }}</p>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-500 mb-1">Address</label>
                <p class="text-xl font-semibold text-gray-800">{{ $school->address }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                <span class="px-3 inline-flex text-sm leading-5 font-semibold rounded-full @if($school->status == 'approved') bg-green-100 text-green-800 @elseif($school->status == 'rejected') bg-red-100 text-red-800 @else bg-yellow-100 text-yellow-800 @endif">
                    {{ ucfirst($school->status) }}
                </span>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Registered At</label>
                <p class="text-xl font-semibold text-gray-800">{{ $school->created_at->format('d M Y, h:i A') }}</p>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-200">
            <div class="flex gap-4">
                <a href="{{ route('admin.schools.edit', $school->id) }}" class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition">
                    Edit School
                </a>
                <form action="{{ route('admin.schools.destroy', $school->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this school?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white py-2 px-6 rounded-lg hover:bg-red-700 transition">
                        Delete School
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
