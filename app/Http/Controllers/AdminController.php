<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\School;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function schools()
    {
        $schools = School::all();
        return view('admin.schools', compact('schools'));
    }

    public function approve($id)
    {
        $school = School::find($id);
        $school->status = 'approved';
        $school->save();
        return redirect()->route('admin.schools')->with('success', 'School approved successfully.');
    }

    public function reject($id)
    {
        $school = School::find($id);
        $school->status = 'rejected';
        $school->save();
        return redirect()->route('admin.schools')->with('success', 'School rejected successfully.');
    }

    public function show($id)
    {
        $school = School::find($id);
        if (!$school) {
            return redirect()->route('admin.schools')->with('error', 'School not found.');
        }
        return view('admin.school_details', compact('school'));
    }

    public function edit($id)
    {
        $school = School::find($id);
        if (!$school) {
            return redirect()->route('admin.schools')->with('error', 'School not found.');
        }
        return view('admin.edit_school', compact('school'));
    }

    public function update(Request $request, $id)
    {
        $school = School::find($id);
        if (!$school) {
            return redirect()->route('admin.schools')->with('error', 'School not found.');
        }

        $data = $request->validate([
            'school_name' => 'required|string',
            'principal_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
        ]);

        // Check for duplicate email (excluding current school)
        $existingSchool = School::where('email', $data['email'])
            ->where('_id', '!=', $id)
            ->first();
        
        if ($existingSchool) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['email' => 'Email already exists for another school.']);
        }

        $school->update($data);

        return redirect()->route('admin.schools')->with('success', 'School updated successfully.');
    }

    public function destroy($id)
    {
        $school = School::find($id);
        if (!$school) {
            return redirect()->route('admin.schools')->with('error', 'School not found.');
        }

        $school->delete();

        return redirect()->route('admin.schools')->with('success', 'School deleted successfully.');
    }
}
