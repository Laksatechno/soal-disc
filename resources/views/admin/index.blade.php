@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Soal</h2>
    <a href="{{ route('master.create') }}" class="btn btn-primary">Tambah Soal</a>
    
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
                            <li>{{ $answer->answer_text }} (Skor: {{ $answer->score }})</li>
                        @endforeach
                    </ul>
                </td>
                <td>
                    <a href="{{ route('master.edit', $question->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('master.destroy', $question->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus soal ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
