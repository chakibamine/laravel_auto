<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quizzes = Quiz::paginate(10);
        return view('quizzes.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('quizzes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'audio' => 'required|mimes:mp3,wav|max:2048',
            'result' => 'required|string',
            'description' => 'required|string',
        ]);

        // Store the image in the specified directory
        $imagePath = $request->file('image_url')->store('quiz/image', 'public');

        // Store the audio in the specified directory
        $audioPath = $request->file('audio')->store('quiz/audio', 'public');

        Quiz::create([
            'image_url' => $imagePath,
            'audio' => $audioPath,
            'result' => $request->result,
            'description' => $request->description,
        ]);

        return redirect()->route('quizzes.index')->with('success', 'Quiz created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $quiz = Quiz::findOrFail($id);
        return view('quizzes.show', compact('quiz'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $quiz = Quiz::findOrFail($id);
        return view('quizzes.edit', compact('quiz'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'audio' => 'nullable|mimes:mp3,wav|max:2048',
            'result' => 'required|string',
            'description' => 'required|string',
        ]);

        $quiz = Quiz::findOrFail($id);

        // Update the image if a new one is uploaded
        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('quiz/image', 'public');
            $quiz->image_url = $imagePath;
        }

        // Update the audio if a new one is uploaded
        if ($request->hasFile('audio')) {
            $audioPath = $request->file('audio')->store('quiz/audio', 'public');
            $quiz->audio = $audioPath;
        }

        $quiz->result = $request->result;
        $quiz->description = $request->description;
        $quiz->save();

        return redirect()->route('quizzes.index')->with('success', 'Quiz updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();

        return redirect()->route('quizzes.index')->with('success', 'Quiz deleted successfully.');
    }
} 