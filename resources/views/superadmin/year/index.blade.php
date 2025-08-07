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
            <main class="col-lg-10 px-4 py-4 content-wrapper">
                <div class="card shadow-sm rounded-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="fw-semibold mb-0">Manage Your Year Book</h4>

                            <div class="d-flex gap-2">

                                <!-- ADD BUTTON -->
                                <button class="btn-custom-add" data-bs-toggle="modal" data-bs-target="#addYearModal">
                                    <iconify-icon icon="mdi:account-plus" width="20" height="20"></iconify-icon>
                                    <span>Add Year Book</span>
                                </button>

                            </div>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- SUCCESS MESSAGE -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- ERROR MESSAGE -->
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th width="30">No</th>
                                        <th>Year</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($yearBooks->isEmpty())
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <div class="py-4">
                                                    <img src="{{ asset('assets/icons/close.png') }}" alt="No Data"
                                                        width="40">
                                                    <p class="mt-2 text-muted">Tidak ada data.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($yearBooks as $index => $yearBook)
                                            <tr>
                                                <td class="text-center">{{ $yearBooks->firstItem() + $index }}</td>
                                                <td>{{ $yearBook->year }}</td>

                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="btn btn-success rounded-3" data-bs-toggle="modal"
                                                            data-bs-target="#editModal{{ $yearBook->id }}">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </button>

                                                        <form action="#" method="POST"
                                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger rounded-3">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            {{ $yearBooks->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
            </main>
        </div>
    </div>

    <!-- Modal Tambah User -->
    <div class="modal fade" id="addYearModal" tabindex="-1" aria-labelledby="addYearModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold" id="addYearModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('superadmin.yearBooks.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tahun</label>
                            <input type="number" name="year" class="form-control" min="1900" max="2100"
                                required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
