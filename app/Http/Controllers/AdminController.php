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
}
