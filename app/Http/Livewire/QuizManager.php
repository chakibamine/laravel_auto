<?php

namespace App\Http\Livewire;

use App\Models\Quiz;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class QuizManager extends Component
{
    use WithPagination, WithFileUploads;

    public $image_url, $audio, $result, $description, $quizId;
    public $showModal = false; // Controls modal visibility
    public $editMode = false;  // Indicates whether in edit mode
    public $searchTerm = ''; // Add this line to declare the searchTerm property
    public $numberOfQuestions; // Add this line to declare the property

    public function render()
    {
        $quizzes = Quiz::where('result', 'like', '%' . $this->searchTerm . '%')
            ->orWhere('description', 'like', '%' . $this->searchTerm . '%')
            ->paginate(10);
        return view('livewire.quiz-manager', compact('quizzes'));
    }

    /**
     * Open the create modal.
     */
    public function create()
    {
        $this->resetFields(); // Reset fields for a new quiz
        $this->showModal = true; // Show the modal
        $this->editMode = false; // Set to create mode
    }

    /**
     * Close the modal.
     */
    public function closeModal()
    {
        $this->showModal = false; // Hide the modal
        $this->resetFields(); // Reset fields
    }

    /**
     * Open the edit modal for a specific quiz.
     */
    public function edit($id)
    {
        $quiz = Quiz::findOrFail($id);
        $this->quizId = $quiz->id;
        $this->image_url = $quiz->image_url;
        $this->audio = $quiz->audio;
        $this->result = $quiz->result;
        $this->description = $quiz->description;
        $this->editMode = true; // Set to edit mode
        $this->showModal = true; // Show the modal
    }

    /**
     * Update or create a quiz.
     */
    public function save()
    {
        $this->validate([
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'audio' => 'nullable|mimes:mp3,wav|max:2048',
            'result' => 'required|string',
            'description' => 'required|string',
        ]);

        if ($this->editMode) {
            $quiz = Quiz::findOrFail($this->quizId);
        } else {
            $quiz = new Quiz();
        }

        // Delete the existing image if a new one is uploaded
        if ($this->image_url) {
            if ($quiz->image_url) {
                Storage::disk('public')->delete($quiz->image_url);
            }
            $imagePath = $this->image_url->store('quiz/image', 'public');
            $quiz->image_url = $imagePath;
        }

        // Delete the existing audio if a new one is uploaded
        if ($this->audio) {
            if ($quiz->audio) {
                Storage::disk('public')->delete($quiz->audio);
            }
            $audioPath = $this->audio->store('quiz/audio', 'public');
            $quiz->audio = $audioPath;
        }

        // Save other fields
        $quiz->result = $this->result;
        $quiz->description = $this->description;
        $quiz->save();

        session()->flash('message', $this->editMode ? 'Quiz updated successfully.' : 'Quiz created successfully.');
        $this->closeModal(); // Close the modal after saving
    }

    /**
     * Delete a quiz.
     */
    public function delete($id)
    {
        $quiz = Quiz::findOrFail($id);

        // Delete the associated image and audio files
        if ($quiz->image_url) {
            Storage::disk('public')->delete($quiz->image_url);
        }
        if ($quiz->audio) {
            Storage::disk('public')->delete($quiz->audio);
        }

        $quiz->delete();
        session()->flash('message', 'Quiz deleted successfully.');
    }

    /**
     * Reset all form fields.
     */
    private function resetFields()
    {
        $this->image_url = null;
        $this->audio = null;
        $this->result = '';
        $this->description = '';
        $this->quizId = null;
    }

    public function selectNumberOfQuestions()
    {
        // Validate the number of questions
        $this->validate([
            'numberOfQuestions' => 'required|integer|min:1',
        ]);

        // Redirect to the random quizzes page with the specified number of questions
        return redirect()->route('random.quizzes', ['number' => $this->numberOfQuestions]);
    }

    public function showRandomQuizzes($number)
    {
        $quizzes = Quiz::inRandomOrder()->take($number)->get(); // Fetch random quizzes
        return view('livewire.random-quizzes', compact('quizzes')); // Create a new view for displaying these quizzes
    }
}