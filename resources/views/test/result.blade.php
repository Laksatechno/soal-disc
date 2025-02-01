<!-- resources/views/test/result.blade.php -->

<h1>Hasil Tes</h1>
<ul>
    @foreach($userAnswers as $userAnswer)
        <li>{{ $userAnswer->question->question_text }} - Jawaban Anda: {{ $userAnswer->answer_text }} - Skor: {{ $userAnswer->score }}</li>
    @endforeach
</ul>

<p>Total Skor: {{ $totalScore }}</p>
