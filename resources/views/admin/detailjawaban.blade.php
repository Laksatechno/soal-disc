@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center">Detail Jawaban</h2>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Pertanyaan</th>
                <th>Jawaban</th>
                <th>Tipe DISC</th>
            </tr>
        </thead>
        <tbody>
            @foreach($userAnswers as $index => $userAnswer)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $userAnswer->question->question_text }}</td>
                <td>{{ $userAnswer->answer->answer_text }}</td>
                <td>{{ $userAnswer->answer->disc_type }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
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