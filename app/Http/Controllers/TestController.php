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
        $questions = Question::with('answers')->get();
        
        // Retrieve session data for email, name, and answers
        $email = session('email');
        $name = session('name');
        $answers = session('answers', []);
    
        return view('test.index', compact('questions', 'email', 'name', 'answers'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string|max:255',
            'answers' => 'required|array', // Pastikan answers adalah array
            'answers.*' => 'required|exists:answers,id', // Pastikan setiap answer_id valid
        ]);

        // Buat user baru
        $user = User::create([
            'email' => $request->email,
            'name' => $request->name
        ]);

        // Simpan jawaban pengguna
        foreach ($request->answers as $question_id => $answer_id) {
            UserAnswer::create([
                'user_id' => $user->id,
                'question_id' => $question_id,
                'answer_id' => $answer_id, // Simpan answer_id
            ]);
        }

        // Redirect ke halaman hasil dengan menyertakan ID user
        return redirect()->route('test.selesai', ['user' => $user->id]);
    }

    public function selesai( User $user) {
        $user = User::with('userAnswers')->find($user->id);
        return view('test.selesai', compact('user'));
    }

    public function result(User $user)
    {
        // Ambil jawaban pengguna beserta relasi question dan answer
        $userAnswers = $user->userAnswers()->with(['question', 'answer'])->get();

        // Hitung total skor berdasarkan disc_type dari jawaban yang dipilih
        $totalScore = [
            'D' => 0,
            'I' => 0,
            'S' => 0,
            'C' => 0,
        ];

        foreach ($userAnswers as $userAnswer) {
            $discType = $userAnswer->answer->disc_type;
            $totalScore[$discType]++;
        }

        return view('test.result', compact('userAnswers', 'totalScore'));
    }
}