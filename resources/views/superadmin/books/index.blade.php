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
                            <h4 class="fw-semibold mb-0">Manage Your Books</h4>

                            <div class="d-flex gap-2">
                                {{-- Form Search --}}
                                <form action="{{ route('superadmin.books.index') }}" method="GET" class="d-flex"
                                    role="search">
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        class="form-control me-2" placeholder="Search Books...">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <img src="{{ asset('assets/icons/search.png') }}" alt="Search Books" width="20"
                                            height="20">
                                    </button>
                                </form>

                                <!-- ADD BUTTON -->
                                <button class="btn-custom-add" data-bs-toggle="modal" data-bs-target="#addModal">
                                    <img src="{{ asset('assets/icons/plus.png') }}" alt="Add Books" width="20"
                                        height="20">
                                    <span>Add Books</span>
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
                                        <th>Cover Book</th>
                                        <th>Class</th>
                                        <th>Judul Buku</th>
                                        <th>Price</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($books->isEmpty())
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
                                        @foreach ($books as $index => $book)
                                            <tr>
                                                <td class="text-center">{{ $books->firstItem() + $index }}</td>
                                                <td>
                                                    @if ($book->image)
                                                        <img src="{{ asset('storage/' . $book->image) }}" alt="photo"
                                                            width="80" height="70" class="rounded"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#coverModal{{ $book->id }}"
                                                            style="cursor:pointer;">

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="coverModal{{ $book->id }}"
                                                            tabindex="-1"
                                                            aria-labelledby="coverModalLabel{{ $book->id }}"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="coverModalLabel{{ $book->id }}">Cover
                                                                            Preview
                                                                        </h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body text-center">
                                                                        <img src="{{ asset('storage/' . $book->image) }}"
                                                                            alt="cover" class="img-fluid rounded">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="alert alert-danger d-inline-block py-1 px-2"
                                                            role="alert">
                                                            <i class="bi bi-image"></i> Tidak ada cover
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>{{ $book->classroom->class_name }}</td>
                                                <td>{{ $book->title }}</td>
                                                <td>Rp {{ number_format($book->price, 0, ',', '.') }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button type="button" class="btn-custom-add"
                                                            style="background: none; border: none; padding: 0; cursor: pointer;"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editModal{{ $book->id }}">
                                                            <img src="{{ asset('assets/icons/edit.png') }}" alt="Edit"
                                                                width="28" height="28">
                                                        </button>

                                                        <form action="{{ route('superadmin.books.destroy', $book->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Apakah Anda yakin ingin Menghapus Data ini?');">
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

                                            <div class="modal fade" id="editModal{{ $book->id }}" tabindex="-1"
                                                aria-labelledby="editModalLabel{{ $book->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel">Edit Books</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <form id="editForm"
                                                                action="{{ route('superadmin.books.update', ['id' => $book->id]) }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')

                                                                <div class="mb-3">
                                                                    <label for="classRoom_id" class="form-label">Class
                                                                        Name</label>
                                                                    <select class="form-select" id="classRoom_id"
                                                                        name="classRoom_id" required>
                                                                        <option value="">-- Select Class Name --
                                                                        </option>
                                                                        @foreach ($classrooms as $class)
                                                                            <option value="{{ $class->id }}"
                                                                                {{ $book->classRoom_id == $class->id ? 'selected' : '' }}>
                                                                                {{ $class->class_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>


                                                                <div class="mb-3">
                                                                    <label for="title" class="form-label">Title</label>
                                                                    <input type="text" class="form-control"
                                                                        id="title" name="title"
                                                                        value="{{ $book->title }}" required>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">Price</label>
                                                                    <input type="text" id="price" name="price"
                                                                        class="form-control" placeholder="Masukkan harga"
                                                                        value="Rp {{ number_format($book->price, 0, ',', '.') }}"
                                                                        required>
                                                                </div>

                                                                {{-- Preview gambar lama --}}
                                                                @if ($book->image)
                                                                    <div class="mb-3">
                                                                        <label class="form-label d-block">Current
                                                                            Image</label>
                                                                        <img src="{{ asset('storage/' . $book->image) }}"
                                                                            alt="Book Image" width="120">
                                                                    </div>
                                                                @endif

                                                                {{-- Upload gambar baru --}}
                                                                <div class="mb-3">
                                                                    <label for="image" class="form-label">Change
                                                                        Image</label>
                                                                    <input type="file" class="form-control"
                                                                        id="image" name="image" accept="image/*">
                                                                    <small class="text-muted">Biarkan kosong jika tidak
                                                                        ingin mengganti gambar.</small>
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
                            {{ $books->links('pagination::bootstrap-5') }}
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
                    <h5 class="modal-title fw-semibold" id="addModalLabel">Add Books</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('superadmin.books.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label">Class ID</label>
                            <select name="classRoom_id" class="form-select" required>
                                <option value="">-- Pilih Class --</option>
                                @foreach ($classrooms as $class)
                                    <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" placeholder="Title" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Price</label>
                            <input type="text" id="price" name="price" class="form-control"
                                placeholder="Masukkan harga" required>
                        </div>

                        {{-- Upload gambar --}}
                        <div class="mb-3">
                            <label for="image" class="form-label">Book Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <small class="text-muted">Opsional. Maksimal 2MB.</small>
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

    <!-- Format Rupiah di Input -->
    <script>
        const priceInput = document.getElementById('price');

        priceInput.addEventListener('input', function() {
            // Hapus semua karakter non-digit
            let value = this.value.replace(/\D/g, '');

            // Format ke Rupiah
            if (value) {
                this.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
            } else {
                this.value = '';
            }
        });
    </script>

@endsection
