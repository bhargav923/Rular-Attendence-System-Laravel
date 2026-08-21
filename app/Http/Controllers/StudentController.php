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
        $data = $request->validate([
            'name' => 'required|string',
            'class' => 'required|string',
            'division' => 'required|string',
            'age' => 'required|numeric',
            'aadhar' => 'required|string',
            'village' => 'required|string',
            'dob' => 'required|date',
            'enrollment_number' => 'nullable|string',
            'barcode' => 'nullable|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'contact_no' => 'nullable|string',
            'emergency_no' => 'nullable|string',
            'batch' => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            $filename = time() . '.' . $request->file('photo')->extension();
            $request->file('photo')->move(public_path('photos'), $filename);
            $path = 'photos/' . $filename;
            $data['image'] = $path;
        }
        unset($data['photo']);

        $data['school_id'] = session('school')->id;
        $student = Student::create($data);

        // Generate a unique enrollment number if the student is new
        if (empty($student->enrollment_number)) {
            $year = date('y');
            $departmentCode = 'SVA'; // As seen in the image
            $sequence = str_pad(Student::count() + 1, 5, '0', STR_PAD_LEFT);
            
            $enrollmentNumber = $year . $departmentCode . $sequence;
            $student->enrollment_number = $enrollmentNumber;

            // The barcode will use the enrollment number
            $student->barcode = $enrollmentNumber;

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

        // Use the dedicated barcode number, or fall back to enrollment/id for older records
        $barcodeValue = $student->barcode ?? $student->enrollment_number ?? $student->id;
        $barcode = \DNS1D::getBarcodeHTML((string)$barcodeValue, 'C128', 1.5, 50);

        return view('student.show', compact('student', 'barcode'));
    }

    public function idcard($id)
    {
        $student = Student::find($id);

        if (!$student || $student->school_id != session('school')->id) {
            return redirect()->route('students.index')->with('error', 'Student not found.');
        }

        // Use the dedicated barcode number, or fall back to enrollment/id for older records
        $barcodeValue = $student->barcode ?? $student->enrollment_number ?? $student->id;
        $barcode = \DNS1D::getBarcodeHTML((string)$barcodeValue, 'C128', 1.5, 50);
        return view('student.idcard', compact('student', 'barcode'));
    }
}
