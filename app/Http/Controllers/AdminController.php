<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Answer;
use App\Models\User;
use App\Models\UserAnswer;

class AdminController extends Controller
{

    public function showLoginForm()
    {
        return view('admin.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $validPin = '123456'; // PIN yang valid

        $pin = $request->input('pin');

        if ($pin === $validPin) {
            // Jika PIN valid, kembalikan response JSON dengan status sukses
            return response()->json([
                'status' => 'success',
                'redirect' => route('admin.index')
            ], 200);
        } else {
            // Jika PIN tidak valid, kembalikan response JSON dengan status error
            return response()->json([
                'status' => 'error',
                'message' => 'PIN salah'
            ], 401);
        }
    }

    //
    public function indexadmin()
    {
        $questions = Question::with('answers')->get();
        return view('admin.index', compact('questions'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function simpansoaladmin(Request $request)
    {
        // Validasi input
        $request->validate([
            'question_text' => 'required|string|max:255', // Validasi untuk pertanyaan
            'answers.*' => 'required|string|max:255',     // Validasi untuk setiap jawaban
            'disc_type.*' => 'required|in:D,I,S,C'        // Validasi untuk tipe DISC (hanya D, I, S, atau C)
        ]);
    
        // Simpan pertanyaan ke database
        $question = Question::create([
            'question_text' => $request->question_text
        ]);
    
        // Simpan jawaban ke database
        foreach ($request->answers as $key => $answer_text) {
            Answer::create([
                'question_id' => $question->id,       // ID pertanyaan yang terkait
                'answer_text' => $answer_text,        // Teks jawaban
                'disc_type' => $request->disc_type[$key] // Tipe DISC dari dropdown
            ]);
        }
    
        // Redirect ke halaman admin dengan pesan sukses
        return redirect()->route('admin.index')->with('success', 'Soal berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $question = Question::with('answers')->findOrFail($id);
        return view('admin.edit', compact('question'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'question_text' => 'required|string|max:255',
            'answers.*' => 'required|string|max:255',
            'disc_type.*' => 'required|in:D,I,S,C'
        ]);

        $question = Question::findOrFail($id);
        $question->update(['question_text' => $request->question_text]);

        $question->answers()->delete(); // Hapus jawaban lama

        foreach ($request->answers as $key => $answer_text) {
            Answer::create([
                'question_id' => $question->id,
                'answer_text' => $answer_text,
                'disc_type' => $request->disc_type[$key]
            ]);
        }

        return redirect()->route('admin.index')->with('success', 'Soal berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();

        return redirect()->route('admin.index')->with('success', 'Soal berhasil dihapus!');
    }

    public function riwayatjawaban() {
        $userAnswers = User::with('userAnswers')->get();
        // dd($userAnswers);
        return view('admin.riwayatjawaban', compact('userAnswers'));
    }

    public function detailjawaban($id) {
        // Ambil semua jawaban pengguna berdasarkan user_id
        $userAnswers = UserAnswer::where('user_id', $id)
                                 ->with(['question', 'answer'])
                                 ->get();

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
    
        // Jika tidak ada jawaban, kembalikan error
        if ($userAnswers->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada jawaban yang ditemukan.');
        }
    
        return view('admin.detailjawaban', compact('userAnswers', 'totalScore'));
    }
}
