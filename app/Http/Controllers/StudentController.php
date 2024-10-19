<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function create()
    {
        return view('students.create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'age' => 'required|integer|min:1',
        ], [
            'email.unique' => 'This email already exists.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $student = new Student();
            $student->name = $request->name;
            $student->email = $request->email;
            $student->age = $request->age;
            $student->save();

            return redirect()->back()->with('success', 'Student added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add student: ' . $e->getMessage());
        }
    }
}
