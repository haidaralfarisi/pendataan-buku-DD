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
                            <h4 class="fw-semibold mb-0">Manage Your User</h4>

                            <div class="d-flex gap-2">
                                {{-- Form Search --}}
                                <form action="{{ route('superadmin.dashboard') }}" method="GET" class="d-flex"
                                    role="search">
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        class="form-control me-2" placeholder="Search User...">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <img src="{{ asset('assets/icons/search.png') }}" alt="Add User" width="20"
                                            height="20">
                                    </button>
                                </form>

                                <!-- ADD BUTTON -->
                                <button class="btn-custom-add" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                    <img src="{{ asset('assets/icons/plus.png') }}" alt="Add User" width="20"
                                        height="20">
                                    <span>Add User</span>
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
                                        <th>Name</th>
                                        <th>NISN</th>
                                        <th>Role</th>
                                        <th>Class Room</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($users->isEmpty())
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <div class="py-4">
                                                    <img src="{{ asset('assets/icons/close.png') }}" alt="No Data"
                                                        width="40">
                                                    <p class="mt-2 text-muted">Tidak ada data User.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($users as $index => $user)
                                            <tr>
                                                <td class="text-center">{{ $users->firstItem() + $index }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->nisn }}</td>
                                                <td>{{ $user->role ?? '-' }}</td>
                                                <td>{{ $user->classroom->class_name ?? '-' }}</td>

                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <button type="button" class="btn-custom-add"
                                                            style="background: none; border: none; padding: 0; cursor: pointer;"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editUserModal{{ $user->id }}">
                                                            <img src="{{ asset('assets/icons/edit.png') }}" alt="Edit"
                                                                width="28" height="28">
                                                        </button>

                                                        <form action="{{ route('superadmin.users.destroy', $user->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
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

                                            <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1"
                                                aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <form id="editUserForm"
                                                                action="{{ route('superadmin.users.update', ['id' => $user->id]) }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')

                                                                <div class="mb-3">
                                                                    <label for="email" class="form-label">Name</label>
                                                                    <input type="text" class="form-control"
                                                                        id="name" name="name"
                                                                        value="{{ $user->name }}" required>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="nisn" class="form-label">NISN</label>
                                                                    <input type="number" class="form-control"
                                                                        id="nisn" name="nisn"
                                                                        value="{{ $user->nisn }}" required>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">Class Room</label>
                                                                    <select name="classroom_id" class="form-select"
                                                                        required>
                                                                        <option value="" disabled
                                                                            {{ empty($user->classroom_id) ? 'selected' : '' }}>
                                                                            -- Select Class Room --
                                                                        </option>
                                                                        @foreach ($classrooms as $classroom)
                                                                            <option value="{{ $classroom->id }}"
                                                                                {{ old('classroom_id', $user->classroom_id) == $classroom->id ? 'selected' : '' }}>
                                                                                {{ $classroom->class_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>


                                                                <div class="mb-3">
                                                                    <label class="form-label">Role</label>
                                                                    <select name="role" id="edit-role"
                                                                        class="form-select" required>
                                                                        <option value="superadmin"
                                                                            {{ $user->role === 'superadmin' ? 'selected' : '' }}>
                                                                            Superadmin</option>
                                                                        <option value="orangtua"
                                                                            {{ $user->role === 'orangtua' ? 'selected' : '' }}>
                                                                            Orang Tua</option>
                                                                    </select>
                                                                </div>


                                                                <div class="alert alert-warning small mt-4"
                                                                    role="alert">
                                                                    Kosongkan password jika tidak ingin mengubahnya.
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">Password</label>
                                                                    <input type="password" name="password"
                                                                        class="form-control">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">Confirm Password</label>
                                                                    <input type="password" name="password_confirmation"
                                                                        class="form-control">
                                                                </div>

                                                                <button type="submit"
                                                                    class="btn btn-primary w-100 rounded-pill">
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
                            {{ $users->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
            </main>
        </div>
    </div>

    <!-- Modal Tambah User -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold" id="addUserModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('superadmin.users.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">NISN</label>
                            <input type="number" name="nisn" class="form-control" placeholder="Nisn" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Class Room</label>
                            <select name="classroom_id" class="form-select" required>
                                <option value="" disabled selected>-- Select Class Room --</option>
                                @foreach ($classrooms as $classroom)
                                    <option value="{{ $classroom->id }}">
                                        {{ $classroom->class_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select" required>
                                <option value="" disabled selected>-- Select role --</option>
                                <option value="superadmin">Superadmin</option>
                                <option value="orangtua">Orang Tua</option>
                                <!-- Tambahkan sesuai kebutuhan -->
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" placeholder="Password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" placeholder="Confirmasi Password"
                                class="form-control" required>
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
