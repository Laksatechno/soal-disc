@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Soal</h2>
    <a href="{{ route('admin.create') }}" class="btn btn-primary">Tambah Soal</a>
    <a href="{{ route('admin.riwayatjawaban')}}" class="btn btn-success"> Riwayat Jawaban</a>
    <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Soal</th>
                <th>Jawaban & Skor</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($questions as $key => $question)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $question->question_text }}</td>
                <td>
                    <ul>
                        @foreach($question->answers as $answer)
                            <li>{{ $answer->answer_text }} (Tipe DISC: {{ $answer->disc_type }})</li>
                        @endforeach
                    </ul>
                </td>
                <td>
                    <a href="{{ route('admin.edit', $question->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.destroy', $question->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus soal ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- Modal -->
<div class="modal fade" id="pinModal" tabindex="-1" aria-labelledby="pinModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pinModalLabel">Masukkan PIN</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="password" id="pinInput" class="form-control" placeholder="Masukkan PIN">
                <div id="pinError" class="text-danger mt-2" style="display: none;">PIN salah!</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="submitPin">Submit</button>
            </div>
        </div>
    </div>
</div>
@endsection

