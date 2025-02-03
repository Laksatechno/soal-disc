@extends('layouts.app')

@section('title', 'DISC Test Andara Medical')

@section('content')
<div class="container">
    <!-- Modal -->
    <div class="modal fade" id="startTestModal" tabindex="-1" aria-labelledby="startTestModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="startTestModalLabel">Mulai Tes DISC</h5>
                </div>
                <div class="modal-body">
                    <p>Anda akan memulai tes DISC. Waktu Anda 15 Menit, pastikan Anda siap sebelum memulai.</p>
                    <p>Pastikan Anda memiliki koneksi internet yang stabil.</p>
                    <p>Apakah Anda yakin ingin memulai tes DISC?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="startTestButton">Mulai Test</button>
                </div>
            </div>
        </div>
    </div>

    <h1 class="text-center">Tes Soal DISC</h1>
    <div class="card mt-4 mb-4">
        <div class="card-body">
            <p>
                <strong>INSTRUKSI:</strong>
                <ul>
                    <li>Anda harus menjawab semua pertanyaan sebelum waktu habis.</li>
                    <li>Waktu Anda: <span id="timer">00:00</span></li>
                </ul>
            </p>
        </div>
    </div>
    <form action="{{ route('test.store') }}" method="POST" id="testForm">
        @csrf

        <div class="form-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" id="email" required>
        </div>
        <div class="form-group mb-3">
            <input type="text" name="name" class="form-control" placeholder="Nama" id="name" required>
        </div>

        <div id="question-container">
            @foreach($questions->chunk(1) as $pageIndex => $questionPage)
            <div class="question-page" data-page="{{ $pageIndex }}" style="display: {{ $pageIndex === 0 ? 'block' : 'none' }};">
                @foreach($questionPage as $question)
                <div class="card mb-3 question-card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $question->question_text }}</h5>
                        <div class="form-check">
                            @foreach($question->answers as $answer)
                            <label class="form-check-label">
                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $answer->id }}"
                                    class="form-check-input"
                                    data-question-id="{{ $question->id }}"
                                    data-answer-id="{{ $answer->id }}">
                                {{ $answer->answer_text }}
                            </label><br>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-between mt-3">
            <button type="button" class="btn btn-secondary" id="prevBtn" style="display: none;">Previous</button>
            <button type="button" class="btn btn-primary" id="nextBtn">Next</button>
        </div>
        
        <button type="submit" class="btn btn-success btn-block mt-3" id="submitBtn" style="display: none;">Kirim Jawaban</button>
    </form>
</div>

<script>
    let currentPage = 0;
    const pages = document.querySelectorAll('.question-page');

    function showPage(pageIndex) {
        pages.forEach((page, index) => {
            page.style.display = (index === pageIndex) ? 'block' : 'none';
        });
        document.getElementById('prevBtn').style.display = pageIndex === 0 ? 'none' : 'inline-block';
        document.getElementById('nextBtn').style.display = pageIndex === pages.length - 1 ? 'none' : 'inline-block';
        document.getElementById('submitBtn').style.display = pageIndex === pages.length - 1 ? 'inline-block' : 'none';
    }

    document.getElementById('nextBtn').addEventListener('click', function () {
        if (currentPage < pages.length - 1) {
            currentPage++;
            showPage(currentPage);
        }
    });

    document.getElementById('prevBtn').addEventListener('click', function () {
        if (currentPage > 0) {
            currentPage--;
            showPage(currentPage);
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        const modal = new bootstrap.Modal(document.getElementById('startTestModal'));
        modal.show();

        document.getElementById('startTestButton').addEventListener('click', function () {
            modal.hide();
            const duration = 60 * 15;
            const display = document.querySelector('#timer');
            startTimer(duration, display);
        });
    });

    function startTimer(duration, display) {
        let timer = duration, minutes, seconds;
        const interval = setInterval(function () {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);
            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;
            display.textContent = minutes + ":" + seconds;
            if (--timer < 0) {
                clearInterval(interval);
                document.getElementById('testForm').submit();
            }
        }, 1000);
    }

    showPage(currentPage);
</script>

@endsection
