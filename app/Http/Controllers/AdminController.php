<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Answer;

class AdminController extends Controller
{
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
}
