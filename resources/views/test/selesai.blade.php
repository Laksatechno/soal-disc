{{-- create view selesai test --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card mt-4">
        <div class="card-body">
            <h3 class="text-center">Selamat {{$user->name}},  telah selesai menjawab semua pertanyaan.</h3>
            {{-- <p class="text-center">Anda dapat melihat hasil tes Anda di halaman <a href="{{ route('test.result') }}">Hasil Tes</a>.</p> --}}
        </div>
    </div>
</div>
@endsection