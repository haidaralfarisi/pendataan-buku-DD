@extends('layouts.app')

@section('content')
    {{-- Navbar --}}
    @include('partials.navbar')

    <div class="container-fluid">
        <div class="row">
            {{-- Sidebar --}}
            <nav class="col-lg-2 p-0 sidebar-scroll" id="sidebarMenu">
                @include('partials.sidebar_superadmin')
            </nav>

            {{-- Konten Utama --}}
            <main class="content-wrapper">
                <h1 class="mb-4 mt-3">Dashboard Orang Tua</h1>

                <div class="card">
                    <div class="card-body">
                        <p>Selamat datang, <strong>{{ Auth::user()->name }}</strong>!</p>
                        <p>Ini adalah halaman khusus Orang Tua.</p>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
