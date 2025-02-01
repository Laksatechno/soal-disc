<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionAnswerSeeder extends Seeder
{
    public function run()
    {
        $questions = [
            'Saya suka mengambil inisiatif dalam tim.',
            'Saya lebih suka bekerja sendiri daripada dalam kelompok.',
            'Saya merasa nyaman dalam situasi sosial yang ramai.',
            'Saya cenderung menghindari konflik dan mencari harmoni.',
            'Saya lebih suka bekerja dengan struktur dan aturan yang jelas.',
            'Saya mudah menyesuaikan diri dengan perubahan mendadak.',
            'Saya lebih suka berbicara daripada mendengarkan dalam diskusi.',
            'Saya cenderung mengambil keputusan berdasarkan fakta, bukan perasaan.',
            'Saya suka mengerjakan tugas dengan cepat dan efisien.',
            'Saya sering menjadi orang yang membuat keputusan dalam kelompok.',
            'Saya lebih suka memotivasi orang lain daripada mengontrol mereka.',
            'Saya lebih suka mengikuti peraturan daripada mengambil risiko.',
            'Saya lebih cenderung fokus pada detail daripada gambaran besar.',
            'Saya menikmati tantangan dan tekanan dalam pekerjaan.',
            'Saya lebih suka memberikan dukungan daripada menjadi pemimpin.',
            'Saya merasa nyaman dalam lingkungan yang berubah-ubah.',
            'Saya lebih suka memiliki hubungan yang erat dengan rekan kerja.',
            'Saya lebih suka bekerja dalam lingkungan yang stabil dan terstruktur.',
            'Saya cenderung memberikan kritik dengan cara yang langsung dan jujur.',
            'Saya lebih suka menyelesaikan tugas dengan cara saya sendiri.',
        ];

        $answers = [
            ['Sangat Setuju', 'D'],
            ['Setuju', 'I'],
            ['Netral', 'S'],
            ['Tidak Setuju', 'C'],
        ];

        foreach ($questions as $index => $question) {
            $questionId = DB::table('questions')->insertGetId([
                'question_text' => $question,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($answers as $answer) {
                DB::table('answers')->insert([
                    'question_id' => $questionId,
                    'answer_text' => $answer[0],
                    'disc_type' => $answer[1],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
