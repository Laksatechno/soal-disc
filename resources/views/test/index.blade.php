<!-- resources/views/test/index.blade.php -->

@extends('layouts.app')

@section('title', 'Test Soal')

@section('content')
<div class="container">
    <h1 class="text-center">Tes Soal DISC</h1>
    <div class="card mt-4 mb-4">
        <div class="card-body">
            <p>
                <strong>INSTRUKSI:</strong>
                <ul>
                    <li>Anda harus menjawab semua pertanyaan dengan benar.</li>
                    <li>Anda hanya dapat menjawab satu pertanyaan sekaligus.</li>
                </ul>
            </p>
        </div>
    </div>
    <form action="{{ route('test.store') }}" method="POST" id="testForm">
        @csrf

        <!-- Email and Name Input, retain values using JavaScript -->
        <div class="form-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" id="email" required>
        </div>
        <div class="form-group mb-3">
            <input type="text" name="name" class="form-control" placeholder="Nama" id="name" required>
        </div>

        @foreach($questions as $question)
        <div class="card mb-3 question-card">
            <div class="card-body">
                <h5 class="card-title">{{ $question->question_text }}</h5>
                <div class="form-check">
                    @foreach($question->answers as $answer)
                    <label class="form-check-label">
                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $answer->answer_text }}"
                            class="form-check-input"
                            data-question-id="{{ $question->id }}"
                            data-answer="{{ $answer->answer_text }}"
                            {{ (isset($answers[$question->id]) && $answers[$question->id] == $answer->answer_text) ? 'checked' : '' }}>
                        {{ $answer->answer_text }}
                    </label><br>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach

        <!-- Pagination for next and previous -->
        {{-- <div class="d-flex justify-content-end mt-3">
            <nav aria-label="Pagination">
                <ul class="pagination pagination-sm">
                    {{ $questions->links() }}
                </ul>
            </nav>
        </div> --}}
        

        <button type="submit" class="btn btn-primary btn-block">Kirim Jawaban</button>
    </form>
</div>

<script>
    // Function to save form data into session storage
    function saveFormData() {
        const email = document.getElementById('email').value;
        const name = document.getElementById('name').value;
        const answers = {};

        // Collect all selected answers
        document.querySelectorAll('input[type="radio"]:checked').forEach((radio) => {
            answers[radio.dataset.questionId] = radio.dataset.answer;
        });

        // Save data into sessionStorage
        sessionStorage.setItem('email', email);
        sessionStorage.setItem('name', name);
        sessionStorage.setItem('answers', JSON.stringify(answers));
    }

    // Function to load form data from session storage
    function loadFormData() {
        const email = sessionStorage.getItem('email');
        const name = sessionStorage.getItem('name');
        const answers = JSON.parse(sessionStorage.getItem('answers')) || {};

        // Set form data from sessionStorage
        if (email) {
            document.getElementById('email').value = email;
        }
        if (name) {
            document.getElementById('name').value = name;
        }

        // Set checked answers based on stored answers
        document.querySelectorAll('input[type="radio"]').forEach((radio) => {
            if (answers[radio.dataset.questionId] === radio.dataset.answer) {
                radio.checked = true;
            }
        });
    }

    // When the page loads, load saved data
    document.addEventListener('DOMContentLoaded', loadFormData);

    // Save form data before the form is submitted
    document.getElementById('testForm').addEventListener('submit', saveFormData);

    // Save form data when navigating between pages (pagination)
    document.querySelectorAll('.pagination a').forEach((link) => {
        link.addEventListener('click', saveFormData);
    });
</script>
@endsection
