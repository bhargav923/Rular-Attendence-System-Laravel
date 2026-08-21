@extends('layouts.app')

@section('title', __('messages.student_register'))

@section('content')
<div class="flex justify-center">
    <div class="w-full md:w-3/4 p-6">

        <h1 class="text-5xl font-bold mb-6 text-center text-blue-700">{{ __('messages.student_register') }}</h1>

        <!-- Toggle Boxes -->
        <div class="flex justify-center gap-4 mb-6">
            <button id="student-details-btn" class="px-6 py-3 rounded-lg bg-blue-600 text-white text-lg font-semibold">{{ __('messages.student_details') }}</button>
            <button id="documents-btn" class="px-6 py-3 rounded-lg bg-gray-200 text-gray-700 text-lg font-semibold">{{ __('messages.upload_documents') }}</button>
        </div>

        <!-- Form -->
        <form action="{{ url('/student/store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Student Details Section -->
            <div id="student-details-section">
                <div class="flex flex-col gap-4 mb-4">
                    <input type="text" name="name" placeholder="{{ __('messages.name') }}" class="p-4 border rounded text-xl w-full" required>
                    <input type="number" name="class" placeholder="{{ __('messages.class') }}" class="p-4 border rounded text-xl w-full" required>
                    <input type="text" name="division" placeholder="{{ __('messages.division') }}" class="p-4 border rounded text-xl w-full">
                    <input type="number" name="age" placeholder="{{ __('messages.age') }}" class="p-4 border rounded text-xl w-full" required>
                    <input type="number" name="batch" placeholder="{{ __('messages.batch') }}" class="p-4 border rounded text-xl w-full">               
                    <input type="number" name="aadhar" placeholder="{{ __('messages.aadhar_no') }}" class="p-4 border rounded text-xl w-full" required>
                    <input type="text" name="village" placeholder="{{ __('messages.village') }}" class="p-4 border rounded text-xl w-full" required>
                    <input type="date" name="dob" placeholder="{{ __('messages.date_of_birth') }}" class="p-4 border rounded text-xl w-full" required>
                    <input type="number" name="contact_no" placeholder="{{ __('messages.contact_no') }}" class="p-4 border rounded text-xl w-full">
                    <input type="number" name="emergency_no" placeholder="{{ __('messages.emergency_contact_no') }}" class="p-4 border rounded text-xl w-full">
                </div>

                <div class="flex justify-end">
                    <button type="button" id="next-btn" class="bg-green-500 text-white py-3 px-6 text-lg rounded hover:bg-green-400 font-semibold">{{ __('messages.save_and_next') }}</button>
                </div>
            </div>

            <!-- Document Upload Section -->
            <div id="documents-section" class="hidden">
                <div class="flex flex-col gap-4 mb-4">
                    <label class="flex flex-col text-xl">{{ __('messages.photo') }}
                        <input type="file" name="photo" class="mt-2 border rounded p-3 w-full" required>
                    </label>
                    <label class="flex flex-col text-xl">{{ __('messages.birth_certificate') }}
                        <input type="file" name="birth_certificate" class="mt-2 border rounded p-3 w-full" required>
                    </label>
                    <label class="flex flex-col text-xl">{{ __('messages.previous_school_certificate') }}
                        <input type="file" name="previous_certificate" class="mt-2 border rounded p-3 w-full">
                    </label>
                    <label class="flex flex-col text-xl">{{ __('messages.other_document') }}
                        <input type="file" name="other_document" class="mt-2 border rounded p-3 w-full">
                    </label>
                </div>

                <div class="flex justify-between">
                    <button type="button" id="previous-btn" class="bg-gray-400 text-white py-3 px-6 text-lg rounded hover:bg-gray-300 font-semibold">{{ __('messages.previous') }}</button>
                    <button type="submit" class="bg-green-500 text-white py-3 px-6 text-lg rounded hover:bg-green-400 font-semibold">{{ __('messages.submit') }}</button>
                </div>
            </div>

        </form>
    </div>
</div>

<script>
    const studentBtn = document.getElementById('student-details-btn');
    const documentsBtn = document.getElementById('documents-btn');
    const studentSection = document.getElementById('student-details-section');
    const documentsSection = document.getElementById('documents-section');
    const nextBtn = document.getElementById('next-btn');
    const previousBtn = document.getElementById('previous-btn');

    studentBtn.addEventListener('click', () => {
        studentSection.classList.remove('hidden');
        documentsSection.classList.add('hidden');
        studentBtn.classList.add('bg-blue-600', 'text-white');
        studentBtn.classList.remove('bg-gray-200','text-gray-700');
        documentsBtn.classList.add('bg-gray-200','text-gray-700');
        documentsBtn.classList.remove('bg-blue-600','text-white');
    });

    documentsBtn.addEventListener('click', () => {
        const name = document.querySelector('input[name="name"]').value.trim();
        const studentClass = document.querySelector('input[name="class"]').value.trim();
        const division = document.querySelector('input[name="division"]').value.trim();
        const age = document.querySelector('input[name="age"]').value.trim();
        const aadhar = document.querySelector('input[name="aadhar"]').value.trim();
        const village = document.querySelector('input[name="village"]').value.trim();
        const dob = document.querySelector('input[name="dob"]').value.trim();

        if (!name || !studentClass || !division || !age || !aadhar || !village || !dob) {
            alert("{{ __('messages.please_fill_student_details_first') }}");
            return;
        }

        studentSection.classList.add('hidden');
        documentsSection.classList.remove('hidden');
        documentsBtn.classList.add('bg-blue-600','text-white');
        documentsBtn.classList.remove('bg-gray-200','text-gray-700');
        studentBtn.classList.add('bg-gray-200','text-gray-700');
        studentBtn.classList.remove('bg-blue-600','text-white');
    });

    nextBtn.addEventListener('click', () => {
        documentsBtn.click();
    });

    previousBtn.addEventListener('click', () => {
        studentBtn.click();
    });

    document.querySelector('form').addEventListener('submit', function(event) {
        const name = document.querySelector('input[name="name"]').value.trim();
        const studentClass = document.querySelector('input[name="class"]').value.trim();
        const aadhar = document.querySelector('input[name="aadhar"]').value.trim();
        const dob = document.querySelector('input[name="dob"]').value.trim();
        const photo = document.querySelector('input[name="photo"]').value.trim();

        if (!name || !studentClass || !aadhar || !dob) {
            alert("{{ __('messages.ensure_all_details_filled') }}");
            studentBtn.click(); // Switch back to the details tab
            event.preventDefault(); // Stop the form from submitting
            return;
        }

        if (!photo) {
            alert("{{ __('messages.please_upload_photo') }}");
            documentsBtn.click(); // Switch to the documents tab
            event.preventDefault(); // Stop the form from submitting
        }
    });

</script>
@endsection
