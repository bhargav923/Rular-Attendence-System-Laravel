<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function register() {
        return view('student.register');
    }

    public function store(Request $request) {
        $school_id = session('school')->id;
        
        // Custom validation messages
        $messages = [
            'name.required' => __('messages.name_required'),
            'name.regex' => __('messages.name_invalid'),
            'class.required' => __('messages.class_required'),
            'division.required' => __('messages.division_required'),
            'age.required' => __('messages.age_required'),
            'age.integer' => __('messages.age_invalid'),
            'age.min' => __('messages.age_invalid'),
            'age.max' => __('messages.age_invalid'),
            'batch.required' => __('messages.batch_required'),
            'aadhar.required' => __('messages.aadhar_required'),
            'aadhar.regex' => __('messages.aadhar_invalid'),
            'village.required' => __('messages.village_required'),
            'village.regex' => __('messages.village_invalid'),
            'dob.required' => __('messages.dob_required'),
            'dob.date' => __('messages.dob_invalid'),
            'dob.before' => __('messages.dob_future'),
            'contact_no.required' => __('messages.contact_required'),
            'contact_no.regex' => __('messages.contact_invalid'),
            'emergency_no.required' => __('messages.emergency_required'),
            'emergency_no.regex' => __('messages.emergency_invalid'),
        ];

        $data = $request->validate([
            'name' => 'required|regex:/^[a-zA-Z\s]+$/',
            'class' => 'required|string',
            'division' => 'required|string',
            'age' => 'required|integer|min:1|max:100',
            'aadhar' => 'required|regex:/^\d{12}$/',
            'village' => 'required|regex:/^[a-zA-Z\s]+$/',
            'dob' => 'required|date|before:today',
            'enrollment_number' => 'nullable|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'contact_no' => 'required|regex:/^\d{10}$/',
            'emergency_no' => 'required|regex:/^\d{10}$/',
            'batch' => 'required|string',
        ], $messages);

        // Check for duplicate Aadhaar
        $existingStudent = Student::where('school_id', $school_id)
            ->where('aadhar', $data['aadhar'])
            ->first();
        
        if ($existingStudent) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['aadhar' => __('messages.aadhar_duplicate')]);
        }

        // Check if contact and emergency numbers are the same
        if ($data['contact_no'] == $data['emergency_no']) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['emergency_no' => __('messages.contact_emergency_same')]);
        }

        // Validate DOB matches age
        $dob = \Carbon\Carbon::parse($data['dob']);
        $calculatedAge = $dob->age;
        
        if ($calculatedAge != $data['age']) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['dob' => __('messages.dob_age_mismatch')]);
        }

        if ($request->hasFile('photo')) {
            $filename = time() . '.' . $request->file('photo')->extension();
            $request->file('photo')->move(public_path('photos'), $filename);
            $path = 'photos/' . $filename;
            $data['image'] = $path;
        }
        unset($data['photo']);

        $data['school_id'] = $school_id;
        $student = Student::create($data);

        // Generate a unique enrollment number if the student is new
        if (empty($student->enrollment_number)) {
            $year = date('y');
            $departmentCode = 'SVA'; // As seen in the image
            $sequence = str_pad(Student::count() + 1, 5, '0', STR_PAD_LEFT);
            
            $enrollmentNumber = $year . $departmentCode . $sequence;
            $student->enrollment_number = $enrollmentNumber;
            $student->save();
        }

        return redirect()->back()->with('success', 'વિદ્યાર્થી સફળતાપૂર્વક નોંધાયો!');
    }

    public function index()
    {
        $school_id = session('school')->id;
        $students = Student::where('school_id', $school_id)->get();
        return view('student.list', compact('students'));
    }

    public function show($id)
    {
        $student = Student::find($id);

        // Ensure the student belongs to the logged-in school and exists
        if (!$student || $student->school_id != session('school')->id) {
            return redirect()->route('students.index')->with('error', 'Student not found.');
        }

        return view('student.show', compact('student'));
    }

    public function edit($id)
    {
        $student = Student::find($id);

        if (!$student || $student->school_id != session('school')->id) {
            return redirect()->route('students.index')->with('error', 'Student not found.');
        }

        return view('student.edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        $school_id = session('school')->id;

        if (!$student || $student->school_id != $school_id) {
            return redirect()->route('students.index')->with('error', 'Student not found.');
        }

        // Custom validation messages
        $messages = [
            'name.required' => __('messages.name_required'),
            'name.regex' => __('messages.name_invalid'),
            'class.required' => __('messages.class_required'),
            'division.required' => __('messages.division_required'),
            'age.required' => __('messages.age_required'),
            'age.integer' => __('messages.age_invalid'),
            'age.min' => __('messages.age_invalid'),
            'age.max' => __('messages.age_invalid'),
            'batch.required' => __('messages.batch_required'),
            'aadhar.required' => __('messages.aadhar_required'),
            'aadhar.regex' => __('messages.aadhar_invalid'),
            'village.required' => __('messages.village_required'),
            'village.regex' => __('messages.village_invalid'),
            'dob.required' => __('messages.dob_required'),
            'dob.date' => __('messages.dob_invalid'),
            'dob.before' => __('messages.dob_future'),
            'contact_no.required' => __('messages.contact_required'),
            'contact_no.regex' => __('messages.contact_invalid'),
            'emergency_no.required' => __('messages.emergency_required'),
            'emergency_no.regex' => __('messages.emergency_invalid'),
        ];

        $data = $request->validate([
            'name' => 'required|regex:/^[a-zA-Z\s]+$/',
            'class' => 'required|string',
            'division' => 'required|string',
            'age' => 'required|integer|min:1|max:100',
            'aadhar' => 'required|regex:/^\d{12}$/',
            'village' => 'required|regex:/^[a-zA-Z\s]+$/',
            'dob' => 'required|date|before:today',
            'enrollment_number' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'contact_no' => 'required|regex:/^\d{10}$/',
            'emergency_no' => 'required|regex:/^\d{10}$/',
            'batch' => 'required|string',
        ], $messages);

        // Check for duplicate Aadhaar (excluding current student)
        $existingStudent = Student::where('school_id', $school_id)
            ->where('aadhar', $data['aadhar'])
            ->where('_id', '!=', $id)
            ->first();
        
        if ($existingStudent) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['aadhar' => __('messages.aadhar_duplicate')]);
        }

        // Check if contact and emergency numbers are the same
        if ($data['contact_no'] == $data['emergency_no']) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['emergency_no' => __('messages.contact_emergency_same')]);
        }

        // Validate DOB matches age
        $dob = \Carbon\Carbon::parse($data['dob']);
        $calculatedAge = $dob->age;
        
        if ($calculatedAge != $data['age']) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['dob' => __('messages.dob_age_mismatch')]);
        }

        if ($request->hasFile('photo')) {
            $filename = time() . '.' . $request->file('photo')->extension();
            $request->file('photo')->move(public_path('photos'), $filename);
            $path = 'photos/' . $filename;
            $data['image'] = $path;
        }
        unset($data['photo']);

        $student->update($data);

        return redirect()->route('students.index')->with('success', __('messages.student_updated_successfully'));
    }

    public function destroy($id)
    {
        $student = Student::find($id);

        if (!$student || $student->school_id != session('school')->id) {
            return redirect()->route('students.index')->with('error', 'Student not found.');
        }

        $student->delete();

        return redirect()->route('students.index')->with('success', __('messages.student_deleted_successfully'));
    }
}
