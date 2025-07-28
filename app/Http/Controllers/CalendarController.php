<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Remainder;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function events()
    {
        try {
            $events = collect();

            // Add Remainders as calendar events (next 30 days)
            $remainders = Remainder::where('date', '>=', Carbon::now()->subDays(30))
                ->where('date', '<=', Carbon::now()->addDays(30))
                ->get()
                ->map(function($reminder) {
                    return [
                        'id' => 'reminder_' . $reminder->id,
                        'title' => 'Rappel: ' . $reminder->name,
                        'start' => $reminder->date,
                        'color' => $reminder->type === 'Urgent' ? '#dc3545' : '#28a745',
                        'description' => $reminder->description,
                        'type' => 'reminder',
                        'extendedProps' => [
                            'type' => $reminder->type,
                            'description' => $reminder->description
                        ]
                    ];
                });

            // Exams with student names (next 30 days)
            $exams = Exam::with('dossier.student')
                ->where('date_exam', '>=', Carbon::now()->subDays(30))
                ->where('date_exam', '<=', Carbon::now()->addDays(30))
                ->get()
                ->map(function($exam) {
                    $studentName = $exam->dossier->student ? 
                        $exam->dossier->student->firstname . ' ' . $exam->dossier->student->lastname : 
                        'Élève inconnu';
                    
                    $studentPhoto = $exam->dossier->student ? 
                        ($exam->dossier->student->image_url ? asset('storage/' . $exam->dossier->student->image_url) : asset('assets/img/default-avatar.png')) : 
                        asset('assets/img/default-avatar.png');
                    
                    $studentPhone = $exam->dossier->student ? 
                        $exam->dossier->student->phone : 
                        'Non disponible';
                    
                    return [
                        'id' => 'exam_' . $exam->id,
                        'title' => 'Exam: ' . $studentName . ' (' . ($exam->type_exam ?? 'Examen') . ')',
                        'start' => $exam->date_exam,
                        'color' => '#e83e8c',
                        'type' => 'exam',
                        'extendedProps' => [
                            'student_name' => $studentName,
                            'student_photo' => $studentPhoto,
                            'student_phone' => $studentPhone,
                            'exam_type' => $exam->type_exam,
                            'resultat' => $exam->resultat
                        ]
                    ];
                });

            return response()->json($exams->merge($remainders));
            
        } catch (\Exception $e) {
            \Log::error('Calendar events error: ' . $e->getMessage());
            return response()->json([]);
        }
    }
} 