@extends('layouts.app')

@section('title', __('messages.edit') . ' ' . __('messages.student_register'))

@section('content')
<div class="flex justify-center">
    <div class="w-full md:w-3/4 p-6">

        <h1 class="text-5xl font-bold mb-6 text-center text-blue-700">{{ __('messages.edit') }} {{ __('messages.student_register') }}</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('student.update', $student->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="flex flex-col gap-4 mb-4">
                <div>
                    <input type="text" name="name" placeholder="{{ __('messages.name') }}" value="{{ $student->name }}" class="p-4 border rounded text-xl w-full" required id="name">
                    <span class="text-red-500 text-sm hidden" id="name-error"></span>
                </div>
                <div>
                    <input type="text" name="class" placeholder="{{ __('messages.class') }}" value="{{ $student->class }}" class="p-4 border rounded text-xl w-full" required id="class">
                    <span class="text-red-500 text-sm hidden" id="class-error"></span>
                </div>
                <div>
                    <input type="text" name="division" placeholder="{{ __('messages.division') }}" value="{{ $student->division }}" class="p-4 border rounded text-xl w-full" required id="division">
                    <span class="text-red-500 text-sm hidden" id="division-error"></span>
                </div>
                <div>
                    <input type="number" name="age" placeholder="{{ __('messages.age') }}" value="{{ $student->age }}" class="p-4 border rounded text-xl w-full" required id="age">
                    <span class="text-red-500 text-sm hidden" id="age-error"></span>
                </div>
                <div>
                    <input type="text" name="batch" placeholder="{{ __('messages.batch') }}" value="{{ $student->batch ?? '' }}" class="p-4 border rounded text-xl w-full" required id="batch">
                    <span class="text-red-500 text-sm hidden" id="batch-error"></span>
                </div>               
                <div>
                    <input type="text" name="aadhar" placeholder="{{ __('messages.aadhar_no') }}" value="{{ $student->aadhar }}" class="p-4 border rounded text-xl w-full" required id="aadhar" maxlength="12">
                    <span class="text-red-500 text-sm hidden" id="aadhar-error"></span>
                </div>
                <div>
                    <input type="text" name="village" placeholder="{{ __('messages.village') }}" value="{{ $student->village }}" class="p-4 border rounded text-xl w-full" required id="village">
                    <span class="text-red-500 text-sm hidden" id="village-error"></span>
                </div>
                <div>
                    <input type="date" name="dob" placeholder="{{ __('messages.date_of_birth') }}" value="{{ $student->dob }}" class="p-4 border rounded text-xl w-full" required id="dob">
                    <span class="text-red-500 text-sm hidden" id="dob-error"></span>
                </div>
                <div>
                    <input type="text" name="contact_no" placeholder="{{ __('messages.contact_no') }}" value="{{ $student->contact_no ?? '' }}" class="p-4 border rounded text-xl w-full" required id="contact_no" maxlength="10">
                    <span class="text-red-500 text-sm hidden" id="contact_no-error"></span>
                </div>
                <div>
                    <input type="text" name="emergency_no" placeholder="{{ __('messages.emergency_contact_no') }}" value="{{ $student->emergency_no ?? '' }}" class="p-4 border rounded text-xl w-full" required id="emergency_no" maxlength="10">
                    <span class="text-red-500 text-sm hidden" id="emergency_no-error"></span>
                </div>
                
                <label class="flex flex-col text-xl">{{ __('messages.photo') }}
                    <input type="file" name="photo" class="mt-2 border rounded p-3 w-full">
                    @if($student->image)
                        <p class="text-sm text-gray-500 mt-1">Current: {{ $student->image }}</p>
                    @endif
                </label>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('students.index') }}" class="bg-gray-400 text-white py-3 px-6 text-lg rounded hover:bg-gray-300 font-semibold">{{ __('messages.cancel') }}</a>
                <button type="submit" class="bg-green-500 text-white py-3 px-6 text-lg rounded hover:bg-green-400 font-semibold">{{ __('messages.save') }}</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Frontend validation functions (same as register form)
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
