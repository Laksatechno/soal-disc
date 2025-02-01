{{-- create list user and button detail --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center">Riwayat Jawaban</h2>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Waktu</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($userAnswers as $index => $userAnswer)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $userAnswer->user->name }}</td>
                <td>{{ $userAnswer->created_at->format('Y-m-d H:i:s') }}</td>
                <td>
                    <a href="{{ route('admin.detailjawaban', $userAnswer->id) }}" class="btn btn-info">Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection