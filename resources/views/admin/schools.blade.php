@extends('layouts.admin')

@section('title', 'Registered Schools')

@section('content')
<div class="p-10">
    <h2 class="text-4xl font-bold mb-8 text-gray-800">Registered Schools</h2>
    
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        @if($schools->isEmpty())
            <div class="p-8 text-center text-gray-500">
                <p class="text-xl">No schools have been registered yet.</p>
            </div>
        @else
            <table class="w-full text-left">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="p-4 font-semibold text-gray-600">School Name</th>
                        <th class="p-4 font-semibold text-gray-600">Principal</th>
                        <th class="p-4 font-semibold text-gray-600">Email</th>
                        <th class="p-4 font-semibold text-gray-600">Phone</th>
                        <th class="p-4 font-semibold text-gray-600">Address</th>
                        <th class="p-4 font-semibold text-gray-600">Registered At</th>
                        <th class="p-4 font-semibold text-gray-600">Status</th>
                        <th class="p-4 font-semibold text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($schools as $school)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="p-4">{{ $school->school_name }}</td>
                        <td class="p-4">{{ $school->principal_name }}</td>
                        <td class="p-4 text-blue-600">{{ $school->email }}</td>
                        <td class="p-4">{{ $school->phone }}</td>
                        <td class="p-4">{{ $school->address }}</td>
                        <td class="p-4 text-sm text-gray-500">{{ $school->created_at->format('d M Y, h:i A') }}</td>
                        <td class="p-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full @if($school->status == 'approved') bg-green-100 text-green-800 @elseif($school->status == 'rejected') bg-red-100 text-red-800 @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($school->status) }}
                            </span>
                        </td>
                        <td class="p-4">
                            @if($school->status == 'pending')
                                <a href="{{ route('admin.schools.approve', $school->id) }}" class="text-green-600 hover:text-green-900">Approve</a>
                                <a href="{{ route('admin.schools.reject', $school->id) }}" class="text-red-600 hover:text-red-900 ml-4">Reject</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
