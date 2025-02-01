<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Question;
use App\Models\Answer;
use App\Models\UserAnswer;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request)
    {
        // Paginate questions
        $questions = Question::with('answers')->paginate(10);
        
        // Retrieve session data for email, name, and answers
        $email = session('email');
        $name = session('name');
        $answers = session('answers', []);
    
        return view('test.index', compact('questions', 'email', 'name', 'answers'));
    }
    

    public function store(Request $request)
    {
        $user = User::create([
            'email' => $request->email,
            'name' => $request->name
        ]);

        foreach ($request->answers as $question_id => $answer_text) {
            $correct_answer = Answer::where('question_id', $question_id)
                                     ->where('answer_text', $answer_text)
                                     ->first();

            $score = $correct_answer ? $correct_answer->score : 0;

            UserAnswer::create([
                'user_id' => $user->id,
                'question_id' => $question_id,
                'answer_text' => $answer_text,
                'score' => $score
            ]);
        }

        return redirect()->route('test.result', ['user' => $user->id]);
    }

    public function result(User $user)
    {
        $userAnswers = $user->userAnswers()->with('question')->get();
        $totalScore = $userAnswers->sum('score');
        return view('test.result', compact('userAnswers', 'totalScore'));
    }
}