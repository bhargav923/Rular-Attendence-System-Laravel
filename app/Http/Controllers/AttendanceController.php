<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Student;

class AttendanceController extends Controller
{
    public function index()
    {
        $school_id = session('school')->id;
        
        // Get all students for this school
        $students = Student::where('school_id', $school_id)->get();
        
        // Group students by class, then by division within each class
        $classGroups = [];
        foreach ($students as $student) {
            if (!isset($classGroups[$student->class])) {
                $classGroups[$student->class] = [
                    'class' => $student->class,
                    'divisions' => []
                ];
            }
            
            $divisionKey = $student->division;
            if (!isset($classGroups[$student->class]['divisions'][$divisionKey])) {
                $classGroups[$student->class]['divisions'][$divisionKey] = [
                    'division' => $student->division,
                    'count' => 0
                ];
            }
            $classGroups[$student->class]['divisions'][$divisionKey]['count']++;
        }
        
        // Sort classes
        ksort($classGroups);
        
        // Sort divisions within each class
        foreach ($classGroups as &$classGroup) {
            ksort($classGroup['divisions']);
            $classGroup['divisions'] = array_values($classGroup['divisions']);
        }
        
        // Convert to indexed array
        $classGroups = array_values($classGroups);
        
        return view('attendance.attendance_page', compact('classGroups'));
    }

    public function markAttendance($class, $division)
    {
        $school_id = session('school')->id;
        
        // Get students for the selected class and division
        $students = Student::where('school_id', $school_id)
            ->where('class', $class)
            ->where('division', $division)
            ->orderBy('enrollment_number')
            ->get();
        
        return view('attendance.mark_attendance_page', compact('students', 'class', 'division'));
    }

    public function storeAttendance(Request $request)
    {
        $validated = $request->validate([
            'class' => 'required|string',
            'division' => 'required|string',
            'date' => 'required|date',
            'students' => 'required|array',
            'students.*.enrollment_number' => 'required|string',
            'students.*.name' => 'required|string',
            'students.*.status' => 'required|in:present,absent',
        ]);

        $school_id = session('school')->id;
        
        // Check for duplicate attendance
        $existingAttendance = Attendance::where('school_id', $school_id)
            ->where('class', $validated['class'])
            ->where('division', $validated['division'])
            ->where('date', $validated['date'])
            ->first();
        
        if ($existingAttendance) {
            return redirect()->route('attendance.mark', ['class' => $validated['class'], 'division' => $validated['division']])->with('error', __('messages.attendance_already_marked'));
        }

        try {
            // Prepare student data with sequential roll numbers
            $studentsData = [];
            foreach ($validated['students'] as $index => $studentData) {
                $student = Student::where('enrollment_number', $studentData['enrollment_number'])
                    ->where('school_id', $school_id)
                    ->first();
                
                // If student not found by enrollment number, try by ID
                if (!$student) {
                    $student = Student::where('id', $studentData['enrollment_number'])
                        ->where('school_id', $school_id)
                        ->first();
                }
                
                $studentsData[] = [
                    'roll_number' => $index + 1, // Sequential roll number starting from 1
                    'enrollment_number' => $student ? ($student->enrollment_number ?: $student->id) : $studentData['enrollment_number'],
                    'student_name' => $studentData['name'],
                    'status' => $studentData['status']
                ];
            }

            Attendance::create([
                'date' => $validated['date'],
                'class' => $validated['class'],
                'division' => $validated['division'],
                'topic' => '',
                'message' => '',
                'subject' => '',
                'lecture_type' => '',
                'period' => '',
                'school_id' => $school_id,
                'students' => $studentsData
            ]);

            return redirect()->route('attendance.history')->with('success', __('messages.attendance_saved_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error saving attendance: ' . $e->getMessage());
        }
    }

    public function history(Request $request)
    {
        $school_id = session('school')->id;
        
        $query = Attendance::where('school_id', $school_id);
        
        // Apply filters
        if ($request->has('date') && $request->date) {
            $query->where('date', $request->date);
        }
        
        if ($request->has('class') && $request->class) {
            $query->where('class', $request->class);
        }
        
        if ($request->has('division') && $request->division) {
            $query->where('division', $request->division);
        }
        
        $attendances = $query->orderBy('date', 'desc')->get();
        
        // Get unique classes and divisions for filters
        $classes = Student::where('school_id', $school_id)
            ->distinct()
            ->pluck('class')
            ->sort()
            ->values();
        
        $divisions = Student::where('school_id', $school_id)
            ->distinct()
            ->pluck('division')
            ->sort()
            ->values();
        
        return view('attendance.attendance_history_page', compact('attendances', 'classes', 'divisions'));
    }

    public function viewAttendance($id)
    {
        $attendance = Attendance::find($id);
        
        if (!$attendance || $attendance->school_id != session('school')->id) {
            return redirect()->route('attendance.history')->with('error', 'Attendance record not found.');
        }
        
        return view('attendance.view_attendance', compact('attendance'));
    }
}
