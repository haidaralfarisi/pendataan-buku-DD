@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Dashboard Admin</h1>

        <div class="card">
            <div class="card-body">
                <p>Selamat datang, <strong>{{ Auth::user()->name }}</strong>!</p>
                <p>Ini adalah halaman khusus Admin.</p>
            </div>
        </div>
    </div>


    <form action="{{ route('logout') }}" method="POST" class="mt-3">
        @csrf
        <button type="submit" class="btn btn-danger">
            Logout
        </button>
    </form>
@endsection
