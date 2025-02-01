@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Soal</h2>

    <form action="{{ route('master.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="question_text" class="form-label">Soal</label>
            <input type="text" name="question_text" class="form-control" required>
        </div>

        <div id="answer-container">
            <label>Jawaban & Skor:</label>
            <div class="mb-2">
                <input type="text" name="answers[]" class="form-control d-inline w-50" required>
                <input type="number" name="scores[]" class="form-control d-inline w-25" required>
            </div>
        </div>
        
        <button type="button" class="btn btn-info" onclick="addAnswer()">Tambah Jawaban</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<script>
    function addAnswer() {
        let index = document.querySelectorAll('#answer-container .mb-2').length;
        let newAnswer = `
            <div class="mb-2">
                <input type="text" name="answers[]" class="form-control d-inline w-50" required>
                <input type="number" name="scores[]" class="form-control d-inline w-25" required>
            </div>
        `;
        document.getElementById('answer-container').insertAdjacentHTML('beforeend', newAnswer);
    }
</script>
@endsection
