<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Display a listing of students
     */
    public function index(Request $request)
    {
        $query = Student::query();

        // Search
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('firstname', 'like', "%{$searchTerm}%")
                  ->orWhere('lastname', 'like', "%{$searchTerm}%")
                  ->orWhere('cin', 'like', "%{$searchTerm}%")
                  ->orWhere('phone', 'like', "%{$searchTerm}%");
            });
        }

        // Filters
        if ($request->has('gender')) {
            $query->where('gender', $request->gender);
        }
        if ($request->has('city')) {
            $query->where('city', $request->city);
        }

        // Sorting
        $sortField = $request->get('sort', 'reg_date');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $students = $query->paginate(10);
        $cities = Student::distinct('city')->pluck('city');

        return view('students.index', compact('students', 'cities'));
    }

    /**
     * Show the form for creating a new student
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created student
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|max:50',
            'lastname' => 'required|max:50',
            'gender' => ['required', Rule::in(['Male', 'Female', 'Other'])],
            'cin' => 'required|max:10',
            'date_birth' => 'required|date',
            'place_birth' => 'required|max:50',
            'address' => 'required|max:50',
            'city' => 'required|max:30',
            'phone' => 'required|max:10',
            'a_firstname' => 'required|max:30',
            'a_lastname' => 'required|max:30',
            'a_place_birth' => 'required|max:50',
            'a_address' => 'required|max:50',
            'photo' => 'nullable|image|max:1024', // Max 1MB
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('students.create')
                ->withErrors($validator)
                ->withInput();
        }

        $student = new Student($request->except('photo'));
        $student->insert_user = auth()->user()->email;
        $student->reg_date = now();

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $student->image_url = $path;
        }

        $student->save();

        return redirect()
            ->route('students.index')
            ->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified student
     */
    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student
     */
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified student
     */
    public function update(Request $request, Student $student)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|max:50',
            'lastname' => 'required|max:50',
            'gender' => ['required', Rule::in(['Male', 'Female', 'Other'])],
            'cin' => 'required|max:10',
            'date_birth' => 'required|date',
            'place_birth' => 'required|max:50',
            'address' => 'required|max:50',
            'city' => 'required|max:30',
            'phone' => 'required|max:10',
            'a_firstname' => 'required|max:30',
            'a_lastname' => 'required|max:30',
            'a_place_birth' => 'required|max:50',
            'a_address' => 'required|max:50',
            'photo' => 'nullable|image|max:1024', // Max 1MB
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('students.edit', $student)
                ->withErrors($validator)
                ->withInput();
        }

        $student->fill($request->except('photo'));

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($student->image_url) {
                Storage::disk('public')->delete($student->image_url);
            }
            
            $path = $request->file('photo')->store('photos', 'public');
            $student->image_url = $path;
        }

        $student->save();

        return redirect()
            ->route('students.index')
            ->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified student
     */
    public function destroy(Student $student)
    {
        // Delete photo if exists
        if ($student->image_url) {
            Storage::disk('public')->delete($student->image_url);
        }

        $student->delete();

        return redirect()
            ->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }

    /**
     * Display the student profile
     */
    public function profile(Student $student)
    {
        $student->load(['exams', 'entries', 'exits']);
        return view('students.profile', compact('student'));
    }

    /**
     * Export student data
     */
    public function export(Student $student)
    {
        // Example: Export student data as JSON
        $filename = "student_{$student->id}.json";
        $data = $student->toJson(JSON_PRETTY_PRINT);

        return response()->streamDownload(function() use ($data) {
            echo $data;
        }, $filename, [
            'Content-Type' => 'application/json',
        ]);
    }

    /**
     * Import student data
     */
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:csv,xlsx|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Add your import logic here
            // Example: Process CSV/Excel file and create students

            return redirect()
                ->route('students.index')
                ->with('success', 'Students imported successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error importing students: ' . $e->getMessage());
        }
    }

    /**
     * Download student photo
     */
    public function downloadPhoto(Student $student)
    {
        if (!$student->image_url || !Storage::disk('public')->exists($student->image_url)) {
            abort(404, 'Photo not found');
        }

        return Storage::disk('public')->download(
            $student->image_url,
            "student_{$student->id}_photo.jpg"
        );
    }

    /**
     * Remove student photo
     */
    public function removePhoto(Student $student)
    {
        if ($student->image_url) {
            Storage::disk('public')->delete($student->image_url);
            $student->image_url = null;
            $student->save();
        }

        return redirect()
            ->back()
            ->with('success', 'Photo removed successfully.');
    }
} 