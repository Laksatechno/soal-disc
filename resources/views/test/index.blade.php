@extends('layouts.app')

@section('title', 'DISC Test Andara Medical')

@section('content')
<div class="">
    <form action="{{ route('test.store') }}" method="POST" id="testForm" class="">
    @csrf

        <!-- Sticky Bar -->
        <div tabindex="" class="top-0 z-50 flex justify-center items-center p-4 border-b border-gray-200 bg-white">
            <div class="text-center">
                <span class="text-gray-500">Waktu Tersisa</span>
                <br>
                <span id="timer" class="text-2xl font-bold text-gray-900">15:00</span>  
            </div>
        </div>

        <!-- Content -->
        <div class="grid lg:grid-cols-3 sm:grid-cols-1 md:grid-cols-1 gap-8 mt-8 mx-8">
            <!-- Notes -->
            <div>
                <div class="bg-white rounded-lg p-4 border border-gray-200 mb-4">
                    <p class="text-center">
                        Catatan
                    </p>
                </div>

                <div class="bg-white rounded-lg p-8 border border-gray-200 h-96">
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Odio dignissimos corrupti laudantium qui, quidem perferendis numquam assumenda, quas molestiae repellat adipisci! Cumque dolore harum sed, vitae nam pariatur dolorem sit!
                </div>
            </div>    

            <!-- Question -->
            <div>
                <div class="bg-white rounded-lg p-4 border border-gray-200 mb-4">
                    <p class="text-center">
                        Soal
                    </p>
                </div>
                
                <div id="question-container" class="bg-white rounded-lg p-8 border border-gray-200 h-96">
                    <!-- Halaman Input Email dan Nama -->
                    <div class="question-page" data-page="0" style="display: block;">
                        <div class="mb-3">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                            <input type="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Masukkan email Anda" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama</label>
                            <input type="text" name="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Masukkan nama Anda" id="name" required>
                        </div>
                    </div>

                    <!-- Halaman Pertanyaan -->
                    @foreach($questions->chunk(1) as $pageIndex => $questionPage)
                    <div class="question-page" data-page="{{ $pageIndex + 1 }}" style="display: none;">
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
            </div>
            
            <!-- Short Cut -->
            <div class="">
                <div class="bg-white rounded-lg p-4 border border-gray-200 mb-4">
                    <p class="text-center">
                        Akses Cepat
                    </p>
                </div>

                <div class="p-8">
                    <p class="text-start">
                        Akses Cepat
                    </p>
                </div>
            </div>
        </div>      

        <!-- <div class="d-flex justify-content-between mt-3">
            <button type="button" class="btn btn-secondary" id="prevBtn" style="display: none;">Previous</button>
            <button type="button" class="btn btn-primary" id="nextBtn">Next</button>
        </div>
        
        <button type="submit" class="btn btn-success btn-block mt-3" id="submitBtn" style="display: none;">Kirim Jawaban</button> -->


        <!-- Navigation -->
        <nav class="bg-white fixed w-full z-20 bottom-0 start-0 border-t border-gray-200">
            <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <button type="button" class="btn btn-secondary" id="prevBtn" >Previous</button>
            <button type="button" class="btn btn-primary" id="nextBtn">Next</button>
            <button type="submit" class="btn btn-success btn-block mt-3" id="submitBtn" >Kirim Jawaban</button>
            </div>
        </nav>
    </form>
</div>

<!-- Main modal -->
<div id="startTestModal" tabindex="-1" aria-hidden="true" class="fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-full bg-gray-500/75 backdrop-blur-sm hidden">
    <div class="relative p-4 w-full max-w-3xl max-h-full">
        
        <div class="relative bg-gray-50 rounded-xl border-gray-900">
            
            <div class="flex items-center justify-center p-4 md:p-5 border-b rounded-t border-gray-200">
                <h3 class="text-xl  font-semibold text-gray-900 ">
                    Perhatian!
                </h3>
            </div>
            
            <div class="p-4 text-center md:p-5 space-y-6">
                <p class="text-base leading-relaxed text-gray-500">
                    Anda akan memulai Tes DISC. Waktu yang Anda miliki adalah <b>15 Menit</b>. Pastikan Anda siap sebelum memulai dan memiliki koneksi internet yang stabil. Waktu hitung mundur tes akan dimulai setelah anda menekan tombol <b>Mulai Test</b>. Pastikan Anda menjawab seluruh pertanyaan sebelum waktu habis.
                </p>
                <p class="text-base leading-relaxed text-gray-500">
                    Apakah Anda yakin ingin memulai tes DISC?
                </p>
            </div>
            
            <div class="flex items-center justify-center p-4 md:p-5 border-t border-gray-200 rounded-b ">
                <button id="startTestButton" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Mulai Test
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let currentPage = 0;
    const pages = document.querySelectorAll('.question-page');

    // function showPage(pageIndex) {
    //     pages.forEach((page, index) => {
    //         page.style.display = (index === pageIndex) ? 'block' : 'none';
    //     });

    //     document.getElementById('prevBtn').style.display = pageIndex === 0 ? 'none' : 'inline-block';
    //     document.getElementById('nextBtn').style.display = pageIndex === pages.length - 1 ? 'none' : 'inline-block';
    //     document.getElementById('submitBtn').style.display = pageIndex === pages.length - 1 ? 'inline-block' : 'none';
    // }

    function showPage(pageIndex) {
        pages.forEach((page, index) => {
            page.style.display = (index === pageIndex) ? 'block' : 'none';
        });

        // Ambil elemen tombol
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const submitBtn = document.getElementById('submitBtn');

        // Kondisi tombol Previous
        prevBtn.disabled = pageIndex === 0;

        // Kondisi tombol Next
        nextBtn.disabled = pageIndex === pages.length - 1;

        // Kondisi tombol Submit
        submitBtn.style.display = "inline-block";
        submitBtn.disabled = pageIndex !== pages.length - 1;
    }


    // Tombol Next
    document.getElementById('nextBtn').addEventListener('click', function () {
        if (currentPage < pages.length - 1) {
            currentPage++;
            showPage(currentPage);
        }
    });

    // Tombol Previous
    document.getElementById('prevBtn').addEventListener('click', function () {
        if (currentPage > 0) {
            currentPage--;
            showPage(currentPage);
        }
    });

    // Modal Start Test
    document.addEventListener('DOMContentLoaded', function () {
        if (!sessionStorage.getItem('testStarted')) {
            document.getElementById('startTestModal').classList.remove('hidden');
        }

        document.getElementById('startTestButton').addEventListener('click', function () {
            document.getElementById('startTestModal').classList.add('hidden');
            sessionStorage.setItem('testStarted', 'true');

            // Tampilkan halaman input pertama
            showPage(0);

            // Jalankan timer 15 menit
            const duration = 60 * 15;
            const display = document.querySelector('#timer');
            startTimer(duration, display);
        });
    });

    // Timer
    function startTimer(duration, display) {
        let timer = duration, minutes, seconds;
        const interval = setInterval(function () {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);
            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = minutes + ":" + seconds;

            // Jika waktu kurang dari 30 detik, ubah warna menjadi merah
            if (timer < 30) {
                display.style.color = "red";
            }

            if (--timer < 0) {
                clearInterval(interval);
                document.getElementById('testForm').submit();
            }
        }, 1000);
    }


    showPage(currentPage);
</script>

@endsection