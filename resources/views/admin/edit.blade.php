@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Soal</h2>

    <form action="{{ route('master.update', $question->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="question_text" class="form-label">Soal</label>
            <input type="text" name="question_text" class="form-control" value="{{ $question->question_text }}" required>
        </div>

        <div id="answer-container">
            <label>Jawaban & Skor:</label>
            @foreach($question->answers as $answer)
                <div class="mb-2 d-flex align-items-center">
                    <input type="text" name="answers[]" class="form-control w-50 me-2" value="{{ $answer->answer_text }}" required>
                    <input type="number" name="scores[]" class="form-control w-25 me-2" value="{{ $answer->score }}" required>
                    <button type="button" class="btn btn-danger btn-sm remove-answer">Hapus</button>
                </div>
            @endforeach
        </div>

        <button type="button" class="btn btn-info" onclick="addAnswer()">Tambah Jawaban</button>
        <br><br>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('master.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script>
    function addAnswer() {
        let newAnswer = `
            <div class="mb-2 d-flex align-items-center">
                <input type="text" name="answers[]" class="form-control w-50 me-2" required>
                <input type="number" name="scores[]" class="form-control w-25 me-2" required>
                <button type="button" class="btn btn-danger btn-sm remove-answer">Hapus</button>
            </div>
        `;
        document.getElementById('answer-container').insertAdjacentHTML('beforeend', newAnswer);
        attachRemoveEvent();
    }

    function attachRemoveEvent() {
        document.querySelectorAll('.remove-answer').forEach(button => {
            button.onclick = function() {
                this.parentElement.remove();
            };
        });
    }

    attachRemoveEvent();
</script>
@endsection
