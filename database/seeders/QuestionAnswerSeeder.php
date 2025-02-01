<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Question;  // Mengimpor model Question
use App\Models\Answer;    // Mengimpor model Answer
use Faker\Factory as Faker;

class QuestionAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        // Membuat 50 soal
        foreach (range(1, 50) as $index) {
            // Buat soal
            $question = Question::create([
                'question_text' => $faker->sentence,
            ]);

            // Buat 2 jawaban untuk setiap soal
            $correctAnswer = Answer::create([
                'question_id' => $question->id,
                'answer_text' => $faker->word,
                'score' => 10,  // Jawaban yang benar
            ]);

            $incorrectAnswer = Answer::create([
                'question_id' => $question->id,
                'answer_text' => $faker->word,
                'score' => 0,   // Jawaban yang salah
            ]);
        }
    }
}
