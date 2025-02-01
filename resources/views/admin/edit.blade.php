@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Soal</h2>

    <form action="{{ route('admin.update', $question->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="question_text" class="form-label">Soal</label>
            <input type="text" name="question_text" class="form-control" value="{{ $question->question_text }}" required>
        </div>

        <div id="answer-container">
            <label>Jawaban & Tipe DISC:</label>
            @foreach($question->answers as $answer)
                <div class="mb-2 d-flex align-items-center">
                    <input type="text" name="answers[]" class="form-control w-50 me-2" value="{{ $answer->answer_text }}" required>
                    <select name="disc_type[]" class="form-control w-25 me-2" required>
                        <option value="D" {{ $answer->disc_type == 'D' ? 'selected' : '' }}>D (Dominance)</option>
                        <option value="I" {{ $answer->disc_type == 'I' ? 'selected' : '' }}>I (Influence)</option>
                        <option value="S" {{ $answer->disc_type == 'S' ? 'selected' : '' }}>S (Steadiness)</option>
                        <option value="C" {{ $answer->disc_type == 'C' ? 'selected' : '' }}>C (Conscientiousness)</option>
                    </select>
                    <button type="button" class="btn btn-danger btn-sm remove-answer">Hapus</button>
                </div>
            @endforeach
        </div>

        <button type="button" class="btn btn-info" onclick="addAnswer()">Tambah Jawaban</button>
        <br><br>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('admin.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script>
    function addAnswer() {
        let newAnswer = `
            <div class="mb-2 d-flex align-items-center">
                <input type="text" name="answers[]" class="form-control w-50 me-2" required>
                <select name="disc_type[]" class="form-control w-25 me-2" required>
                    <option value="D">D (Dominance)</option>
                    <option value="I">I (Influence)</option>
                    <option value="S">S (Steadiness)</option>
                    <option value="C">C (Conscientiousness)</option>
                </select>
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