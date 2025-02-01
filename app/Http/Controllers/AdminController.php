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
        $request->validate([
            'question_text' => 'required|string|max:255',
            'answers.*' => 'required|string|max:255',
            'scores.*' => 'required|integer|min:0'
        ]);

        $question = Question::create(['question_text' => $request->question_text]);

        foreach ($request->answers as $key => $answer_text) {
            Answer::create([
                'question_id' => $question->id,
                'answer_text' => $answer_text,
                'score' => $request->scores[$key]
            ]);
        }

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
            'scores.*' => 'required|integer|min:0'
        ]);

        $question = Question::findOrFail($id);
        $question->update(['question_text' => $request->question_text]);

        $question->answers()->delete(); // Hapus jawaban lama

        foreach ($request->answers as $key => $answer_text) {
            Answer::create([
                'question_id' => $question->id,
                'answer_text' => $answer_text,
                'score' => $request->scores[$key]
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
