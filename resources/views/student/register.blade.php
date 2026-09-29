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
                    <div>
                        <input type="text" name="name" placeholder="{{ __('messages.name') }}" class="p-4 border rounded text-xl w-full" required id="name">
                        <span class="text-red-500 text-sm hidden" id="name-error"></span>
                    </div>
                    <div>
                        <input type="text" name="class" placeholder="{{ __('messages.class') }}" class="p-4 border rounded text-xl w-full" required id="class">
                        <span class="text-red-500 text-sm hidden" id="class-error"></span>
                    </div>
                    <div>
                        <input type="text" name="division" placeholder="{{ __('messages.division') }}" class="p-4 border rounded text-xl w-full" required id="division">
                        <span class="text-red-500 text-sm hidden" id="division-error"></span>
                    </div>
                    <div>
                        <input type="number" name="age" placeholder="{{ __('messages.age') }}" class="p-4 border rounded text-xl w-full" required id="age">
                        <span class="text-red-500 text-sm hidden" id="age-error"></span>
                    </div>
                    <div>
                        <input type="text" name="batch" placeholder="{{ __('messages.batch') }}" class="p-4 border rounded text-xl w-full" required id="batch">
                        <span class="text-red-500 text-sm hidden" id="batch-error"></span>
                    </div>               
                    <div>
                        <input type="text" name="aadhar" placeholder="{{ __('messages.aadhar_no') }}" class="p-4 border rounded text-xl w-full" required id="aadhar" maxlength="12">
                        <span class="text-red-500 text-sm hidden" id="aadhar-error"></span>
                    </div>
                    <div>
                        <input type="text" name="village" placeholder="{{ __('messages.village') }}" class="p-4 border rounded text-xl w-full" required id="village">
                        <span class="text-red-500 text-sm hidden" id="village-error"></span>
                    </div>
                    <div>
                        <input type="date" name="dob" placeholder="{{ __('messages.date_of_birth') }}" class="p-4 border rounded text-xl w-full" required id="dob">
                        <span class="text-red-500 text-sm hidden" id="dob-error"></span>
                    </div>
                    <div>
                        <input type="text" name="contact_no" placeholder="{{ __('messages.contact_no') }}" class="p-4 border rounded text-xl w-full" required id="contact_no" maxlength="10">
                        <span class="text-red-500 text-sm hidden" id="contact_no-error"></span>
                    </div>
                    <div>
                        <input type="text" name="emergency_no" placeholder="{{ __('messages.emergency_contact_no') }}" class="p-4 border rounded text-xl w-full" required id="emergency_no" maxlength="10">
                        <span class="text-red-500 text-sm hidden" id="emergency_no-error"></span>
                    </div>
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
        const name = document.getElementById('name').value.trim();
        const studentClass = document.getElementById('class').value.trim();
        const division = document.getElementById('division').value.trim();
        const age = document.getElementById('age').value.trim();
        const batch = document.getElementById('batch').value.trim();
        const aadhar = document.getElementById('aadhar').value.trim();
        const village = document.getElementById('village').value.trim();
        const dob = document.getElementById('dob').value.trim();
        const contact = document.getElementById('contact_no').value.trim();
        const emergency = document.getElementById('emergency_no').value.trim();

        // Validate all fields before proceeding
        let isValid = true;
        isValid = validateField('name', name, validateName, 'name-error') && isValid;
        isValid = validateField('class', studentClass, validateClass, 'class-error') && isValid;
        isValid = validateField('division', division, validateDivision, 'division-error') && isValid;
        isValid = validateField('age', age, validateAge, 'age-error') && isValid;
        isValid = validateField('batch', batch, validateBatch, 'batch-error') && isValid;
        isValid = validateField('aadhar', aadhar, validateAadhar, 'aadhar-error') && isValid;
        isValid = validateField('village', village, validateVillage, 'village-error') && isValid;
        isValid = validateField('dob', dob, validateDob, 'dob-error') && isValid;
        isValid = validateField('contact_no', contact, validateContact, 'contact_no-error') && isValid;
        isValid = validateField('emergency_no', emergency, validateEmergency, 'emergency_no-error') && isValid;

        if (!isValid) {
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
        const name = document.getElementById('name').value.trim();
        const studentClass = document.getElementById('class').value.trim();
        const division = document.getElementById('division').value.trim();
        const age = document.getElementById('age').value.trim();
        const batch = document.getElementById('batch').value.trim();
        const aadhar = document.getElementById('aadhar').value.trim();
        const village = document.getElementById('village').value.trim();
        const dob = document.getElementById('dob').value.trim();
        const contact = document.getElementById('contact_no').value.trim();
        const emergency = document.getElementById('emergency_no').value.trim();
        const photo = document.querySelector('input[name="photo"]').value.trim();

        // Validate all fields before submitting
        let isValid = true;
        isValid = validateField('name', name, validateName, 'name-error') && isValid;
        isValid = validateField('class', studentClass, validateClass, 'class-error') && isValid;
        isValid = validateField('division', division, validateDivision, 'division-error') && isValid;
        isValid = validateField('age', age, validateAge, 'age-error') && isValid;
        isValid = validateField('batch', batch, validateBatch, 'batch-error') && isValid;
        isValid = validateField('aadhar', aadhar, validateAadhar, 'aadhar-error') && isValid;
        isValid = validateField('village', village, validateVillage, 'village-error') && isValid;
        isValid = validateField('dob', dob, validateDob, 'dob-error') && isValid;
        isValid = validateField('contact_no', contact, validateContact, 'contact_no-error') && isValid;
        isValid = validateField('emergency_no', emergency, validateEmergency, 'emergency_no-error') && isValid;

        if (!isValid) {
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

<script>
    // Frontend validation functions
    function validateField(field, value, validationFunction, errorElementId) {
        const errorElement = document.getElementById(errorElementId);
        const inputElement = document.getElementById(field);
        
        const result = validationFunction(value);
        
        if (result.valid) {
            errorElement.classList.add('hidden');
            inputElement.classList.remove('border-red-500');
            inputElement.classList.add('border');
            return true;
        } else {
            errorElement.textContent = result.message;
            errorElement.classList.remove('hidden');
            inputElement.classList.remove('border');
            inputElement.classList.add('border-red-500');
            return false;
        }
    }

    function validateName(value) {
        if (!value.trim()) {
            return { valid: false, message: '{{ __("messages.name_required") }}' };
        }
        if (!/^[a-zA-Z\s]+$/.test(value)) {
            return { valid: false, message: '{{ __("messages.name_invalid") }}' };
        }
        return { valid: true };
    }

    function validateClass(value) {
        if (!value.trim()) {
            return { valid: false, message: '{{ __("messages.class_required") }}' };
        }
        return { valid: true };
    }

    function validateDivision(value) {
        if (!value.trim()) {
            return { valid: false, message: '{{ __("messages.division_required") }}' };
        }
        return { valid: true };
    }

    function validateAge(value) {
        if (!value.trim()) {
            return { valid: false, message: '{{ __("messages.age_required") }}' };
        }
        const age = parseInt(value);
        if (isNaN(age) || age < 1 || age > 100) {
            return { valid: false, message: '{{ __("messages.age_invalid") }}' };
        }
        return { valid: true };
    }

    function validateBatch(value) {
        if (!value.trim()) {
            return { valid: false, message: '{{ __("messages.batch_required") }}' };
        }
        return { valid: true };
    }

    function validateAadhar(value) {
        if (!value.trim()) {
            return { valid: false, message: '{{ __("messages.aadhar_required") }}' };
        }
        if (!/^\d{12}$/.test(value)) {
            return { valid: false, message: '{{ __("messages.aadhar_invalid") }}' };
        }
        return { valid: true };
    }

    function validateVillage(value) {
        if (!value.trim()) {
            return { valid: false, message: '{{ __("messages.village_required") }}' };
        }
        if (!/^[a-zA-Z\s]+$/.test(value)) {
            return { valid: false, message: '{{ __("messages.village_invalid") }}' };
        }
        return { valid: true };
    }

    function validateDob(value) {
        if (!value.trim()) {
            return { valid: false, message: '{{ __("messages.dob_required") }}' };
        }
        const dob = new Date(value);
        const today = new Date();
        if (dob > today) {
            return { valid: false, message: '{{ __("messages.dob_future") }}' };
        }
        
        // Check age match
        const ageInput = document.getElementById('age').value;
        if (ageInput) {
            const calculatedAge = Math.floor((today - dob) / (365.25 * 24 * 60 * 60 * 1000));
            if (calculatedAge !== parseInt(ageInput)) {
                return { valid: false, message: '{{ __("messages.dob_age_mismatch") }}' };
            }
        }
        
        return { valid: true };
    }

    function validateContact(value) {
        if (!value.trim()) {
            return { valid: false, message: '{{ __("messages.contact_required") }}' };
        }
        if (!/^\d{10}$/.test(value)) {
            return { valid: false, message: '{{ __("messages.contact_invalid") }}' };
        }
        return { valid: true };
    }

    function validateEmergency(value) {
        if (!value.trim()) {
            return { valid: false, message: '{{ __("messages.emergency_required") }}' };
        }
        if (!/^\d{10}$/.test(value)) {
            return { valid: false, message: '{{ __("messages.emergency_invalid") }}' };
        }
        
        // Check if same as contact
        const contact = document.getElementById('contact_no').value;
        if (contact && value === contact) {
            return { valid: false, message: '{{ __("messages.contact_emergency_same") }}' };
        }
        
        return { valid: true };
    }

    // Add real-time validation listeners
    document.addEventListener('DOMContentLoaded', function() {
        const fields = [
            { id: 'name', validator: validateName, errorId: 'name-error' },
            { id: 'class', validator: validateClass, errorId: 'class-error' },
            { id: 'division', validator: validateDivision, errorId: 'division-error' },
            { id: 'age', validator: validateAge, errorId: 'age-error' },
            { id: 'batch', validator: validateBatch, errorId: 'batch-error' },
            { id: 'aadhar', validator: validateAadhar, errorId: 'aadhar-error' },
            { id: 'village', validator: validateVillage, errorId: 'village-error' },
            { id: 'dob', validator: validateDob, errorId: 'dob-error' },
            { id: 'contact_no', validator: validateContact, errorId: 'contact_no-error' },
            { id: 'emergency_no', validator: validateEmergency, errorId: 'emergency_no-error' },
        ];

        fields.forEach(field => {
            const input = document.getElementById(field.id);
            if (input) {
                input.addEventListener('blur', function() {
                    validateField(field.id, this.value, field.validator, field.errorId);
                });
                
                input.addEventListener('input', function() {
                    // Clear error on input
                    const errorElement = document.getElementById(field.errorId);
                    errorElement.classList.add('hidden');
                    input.classList.remove('border-red-500');
                    input.classList.add('border');
                });
            }
        });
    });
</script>
@endsection
