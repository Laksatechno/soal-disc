@extends('layouts.app')

@section('title', 'Hasil Tes')

@section('content')
<div class="container">
    <h1 class="text-center">Hasil Tes DISC</h1>
    <div class="card mt-4">
        <div class="card-body">
            <h3>Detail Jawaban</h3>
            <ul>
                @foreach($userAnswers as $userAnswer)
                    <li>
                        <strong>Pertanyaan:</strong> {{ $userAnswer->question->question_text }}<br>
                        <strong>Jawaban:</strong> {{ $userAnswer->answer->answer_text }}<br>
                        <strong>Tipe DISC:</strong> {{ $userAnswer->answer->disc_type }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-body">
            <h3>Total Skor DISC</h3>
            <ul>
                <li><strong>D (Dominance):</strong> {{ $totalScore['D'] }}</li>
                <li><strong>I (Influence):</strong> {{ $totalScore['I'] }}</li>
                <li><strong>S (Steadiness):</strong> {{ $totalScore['S'] }}</li>
                <li><strong>C (Conscientiousness):</strong> {{ $totalScore['C'] }}</li>
            </ul>
        </div>
    </div>
</div>
@endsection