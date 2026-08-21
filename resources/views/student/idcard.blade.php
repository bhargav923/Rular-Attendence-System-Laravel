@extends('layouts.app')

@section('styles')
<style>
    body {
        background-color: #e5e7eb; /* bg-gray-200 */
    }
    .id-card-container {
        width: 350px;
        height: 550px;
    }
    .id-card-header::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: repeating-linear-gradient(45deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.05) 1px, transparent 1px, transparent 8px),
        repeating-linear-gradient(-45deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.05) 1px, transparent 1px, transparent 8px);
    }
    @media print {
        body * {
            visibility: hidden;
        }
        .printable-area, .printable-area * {
            visibility: visible;
        }
        .printable-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .no-print {
            display: none;
        }
    }
</style>
@endsection

@section('content')
<div class="flex flex-col items-center">
    <div class="id-card-container bg-white shadow-2xl rounded-2xl font-sans overflow-hidden printable-area flex flex-col">
        <!-- Header -->
        <div class="h-32 relative bg-gradient-to-br from-blue-500 to-indigo-600 id-card-header">
            <div class="absolute -bottom-12 w-full flex justify-center">
                <div class="w-28 h-28 rounded-full bg-gray-300 border-4 border-white overflow-hidden">
                    @if($student->image)
                        <img src="{{ asset($student->image) }}" alt="Student Photo" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-500">No Photo</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Details -->
        <div class="p-4 pt-16 text-center flex-grow">
            <h2 class="text-xl font-bold uppercase">{{ $student->name }}</h2>
            <p class="text-md text-gray-700 mt-4"><strong>Enrollment No.:</strong> {{ $student->enrollment_number ?? $student->id }}</p>
            <p class="text-sm text-gray-600 mt-2 mb-2"><strong>Batch:</strong> {{ $student->batch ?? 'N/A' }} | <strong>DOB:</strong> {{ \Carbon\Carbon::parse($student->dob)->format('d/m/Y') }}</p>
            
            <div class="border-t border-gray-200 my-2"></div>

            <div class="text-sm text-gray-800 mt-4">
                <p class="font-semibold uppercase text-base">{{ $student->village }}</p>
            </div>

            <!-- Barcode -->
            <div class="mt-auto pt-8 px-4 flex flex-col items-center">
                <div class="text-sm text-gray-700 mb-3">
                    <p><strong>Contact:</strong> {{ $student->contact_no ?? 'N/A' }}</p>
                    <p><strong>Emergency:</strong> {{ $student->emergency_no ?? 'N/A' }}</p>
                </div>
                <div class="border-t border-gray-300 w-3/4 my-2"></div>
                {!! $barcode !!}
                <p class="text-xs tracking-widest mt-1">{{ $student->barcode ?? $student->enrollment_number ?? $student->id }}</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-blue-800 text-white text-center p-2">
            <p class="font-semibold uppercase text-sm">{{ session('school')->name ?? 'Shreeji school' }}</p>
        </div>
    </div>

    <div class="mt-6 no-print flex justify-center space-x-4">
        <button id="download-btn" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">Download</button>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    document.getElementById('download-btn').addEventListener('click', function() {
        const idCardElement = document.querySelector('.printable-area');
        
        html2canvas(idCardElement, {
            scale: 2, // Improves image quality
            useCORS: true, // Needed for images served from a different origin
            onclone: (document) => {
                // This is a workaround to ensure images load before the canvas is drawn
                // especially for images coming from a different route like ours.
            }
        }).then(canvas => {
            const link = document.createElement('a');
            link.download = 'student-id-card-{{ $student->enrollment_number ?? $student->id }}.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
        });
    });
</script>
@endsection
