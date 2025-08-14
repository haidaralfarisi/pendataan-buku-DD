@extends('layouts.app')

@section('custom_css')
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
@endsection

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="height:100vh; overflow:hidden;">
        <div class="bg-white border border-0 rounded-5" style="width: 500px">
            <div class="p-5">
                <div class="mb-4">
                    <img src="{{ asset('assets/icons/ic-logo-dd.png') }}" height="75" alt="">
                </div>
                {{-- @include('layouts.alert') --}}
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label class="form-label" for="nisn">NISN</label>
                        <input id="nisn" type="number" class="form-control @error('nisn') is-invalid @enderror"
                            name="nisn" placeholder="Masukkan NISN" value="{{ old('nisn') }}" required
                            autocomplete="username" autofocus>

                        @error('nisn')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


                    <div class="form-group mb-3">
                        <label class="form-label">Password</label>
                        <input id="password" type="password"
                            class="form-control input @error('password') is-invalid @enderror" name="password"
                            placeholder="Password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group py-2">
                        <button type="submit" class="btn btn-primary w-100 rounded-3">
                            {{ __('Login') }}
                        </button>
                    </div>
                </form>


                <div class="d-flex justify-content-center">
                    <div class="form-text">
                        <small>&hearts; developed by IT Dev dian didaktika &hearts; </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
