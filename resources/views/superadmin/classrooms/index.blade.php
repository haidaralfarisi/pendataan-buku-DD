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
                            <h4 class="fw-semibold mb-0">Manage Your Class Rooms</h4>

                            <div class="d-flex gap-2">

                                <!-- ADD BUTTON -->
                                <button class="btn-custom-add" data-bs-toggle="modal" data-bs-target="#addModal">
                                    <img src="{{ asset('assets/icons/plus.png') }}" alt="Add Class" width="20"
                                        height="20">
                                    <span>Add Class Rooms</span>
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
                                        <th>Class Name</th>
                                        <th>Year Book ID</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($classrooms->isEmpty())
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
                                        @foreach ($classrooms as $index => $classroom)
                                            <tr>
                                                <td class="text-center">{{ $classrooms->firstItem() + $index }}</td>
                                                <td>{{ $classroom->class_name }}</td>
                                                <td>{{ $classroom->yearBook->year }}</td>

                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button type="button" class="btn-custom-add"
                                                            style="background: none; border: none; padding: 0; cursor: pointer;"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editModal{{ $classroom->id }}">
                                                            <img src="{{ asset('assets/icons/edit.png') }}" alt="Edit"
                                                                width="28" height="28">
                                                        </button>

                                                        <form
                                                            action="{{ route('superadmin.classRooms.destroy', $classroom->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus Class Room ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn-custom-add"
                                                                style="background: none; border: none; padding: 0; cursor: pointer;">
                                                                <img src="{{ asset('assets/icons/trash.png') }}"
                                                                    alt="Hapus" width="28" height="28">
                                                            </button>
                                                        </form>
                                                    </div>

                                                </td>
                                            </tr>

                                            <div class="modal fade" id="editModal{{ $classroom->id }}" tabindex="-1"
                                                aria-labelledby="editModalLabel{{ $classroom->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel">Edit
                                                                Class Room</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <form id="editForm"
                                                                action="{{ route('superadmin.classRooms.update', ['id' => $classroom->id]) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')

                                                                <div class="mb-3">
                                                                    <label for="class_name" class="form-label">Class
                                                                        Name</label>
                                                                    <input type="text" class="form-control"
                                                                        id="class_name" name="class_name"
                                                                        value="{{ $classroom->class_name }}" required>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="year_book_id" class="form-label">Year
                                                                        Book</label>
                                                                    <select class="form-select" id="year_book_id"
                                                                        name="year_book_id" required>
                                                                        <option value="">-- Select Year Book --
                                                                        </option>
                                                                        @foreach ($yearBooks as $yb)
                                                                            <option value="{{ $yb->id }}"
                                                                                {{ $classroom->year_book_id == $yb->id ? 'selected' : '' }}>
                                                                                {{ $yb->year }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>


                                                                <button type="submit" class="btn btn-primary w-100 rounded-pill">
                                                                    Save Changes
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            {{ $classrooms->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
            </main>
        </div>
    </div>

    <!-- Modal Tambah Data -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold" id="addModalLabel">Add Class</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('superadmin.classRooms.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Class Name</label>
                            <input type="text" name="class_name" placeholder="Class Name" class="form-control"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Year Book</label>
                            <select name="year_book_id" class="form-select" required>
                                <option value="">-- Pilih Tahun --</option>
                                @foreach ($yearBooks as $yearBook)
                                    <option value="{{ $yearBook->id }}">{{ $yearBook->year }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
