<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\Answer;

class QuestionAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Data pertanyaan dan jawaban untuk tes DISC
        $questions = [
            [
                'question_text' => 'Saya cenderung mengambil keputusan dengan cepat.',
                'answers' => [
                    ['answer_text' => 'Sangat Setuju', 'disc_type' => 'D'],
                    ['answer_text' => 'Setuju', 'disc_type' => 'I'],
                    ['answer_text' => 'Tidak Setuju', 'disc_type' => 'S'],
                    ['answer_text' => 'Sangat Tidak Setuju', 'disc_type' => 'C'],
                ],
            ],
            [
                'question_text' => 'Saya suka bekerja dalam tim.',
                'answers' => [
                    ['answer_text' => 'Sangat Setuju', 'disc_type' => 'I'],
                    ['answer_text' => 'Setuju', 'disc_type' => 'S'],
                    ['answer_text' => 'Tidak Setuju', 'disc_type' => 'D'],
                    ['answer_text' => 'Sangat Tidak Setuju', 'disc_type' => 'C'],
                ],
            ],
            [
                'question_text' => 'Saya lebih suka mengikuti aturan yang sudah ada.',
                'answers' => [
                    ['answer_text' => 'Sangat Setuju', 'disc_type' => 'C'],
                    ['answer_text' => 'Setuju', 'disc_type' => 'S'],
                    ['answer_text' => 'Tidak Setuju', 'disc_type' => 'D'],
                    ['answer_text' => 'Sangat Tidak Setuju', 'disc_type' => 'I'],
                ],
            ],
            // Tambahkan lebih banyak pertanyaan dan jawaban sesuai kebutuhan
        ];

        // Loop melalui setiap pertanyaan dan buat record di database
        foreach ($questions as $questionData) {
            $question = Question::create([
                'question_text' => $questionData['question_text'],
            ]);

            foreach ($questionData['answers'] as $answerData) {
                Answer::create([
                    'question_id' => $question->id,
                    'answer_text' => $answerData['answer_text'],
                    'disc_type' => $answerData['disc_type'],
                ]);
            }
        }
    }
}