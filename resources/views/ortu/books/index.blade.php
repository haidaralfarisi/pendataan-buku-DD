@extends('layouts.app')

@section('content')
    {{-- Navbar --}}
    @include('partials.navbar')

    <div class="container-fluid">
        <div class="row">
            {{-- Sidebar --}}
            <nav class="col-lg-2 p-0 sidebar-scroll" id="sidebarMenu">
                @include('partials.sidebar_orangtua')
            </nav>

            {{-- Konten Utama --}}
            <main class="col-lg-10 px-4 py-4 content-wrapper">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            {{-- Form Search --}}
                            <form action="{{ route('ortu.books.index') }}" method="GET" class="d-flex" role="search">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control me-2" placeholder="Search Books...">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <img src="{{ asset('assets/icons/search.png') }}" alt="Search Books" width="20"
                                        height="20">
                                </button>
                            </form>
                        </div>

                        <div class="container py-3">
                            <h4 class="fw-semibold mb-3">Choose Your Books</h4>

                            <form action="{{ route('orders.store') }}" method="POST">
                                @csrf

                                <!-- Scroll Vertical -->
                                <div class="book-list-container">
                                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
                                        @forelse($books as $book)
                                            @php
                                                $bgColors = ['#fef4f4', '#f4f9ff', '#f4fff8', '#fffaf4', '#f4f4ff'];
                                                $randomBg = $bgColors[array_rand($bgColors)];
                                            @endphp

                                            <div class="col">
                                                <div class="book-card p-2 rounded shadow-sm h-100"
                                                    style="background-color: {{ $randomBg }}">
                                                    @if ($book->image)
                                                        <img src="{{ asset('storage/' . $book->image) }}"
                                                            alt="{{ $book->title }}" class="book-img rounded">
                                                    @else
                                                        <div class="book-img placeholder d-flex align-items-center justify-content-center bg-light rounded"
                                                            style="height:150px">
                                                            <span class="text-muted">No Cover</span>
                                                        </div>
                                                    @endif

                                                    <div class="book-info mt-2">
                                                        <h6 class="book-title mb-0">{{ $book->title }}</h6>
                                                        <p class="book-class small mb-0">
                                                            {{ $book->classroom->class_name ?? '-' }}</p>
                                                        <p class="book-price fw-bold text-primary mb-0">
                                                            Rp {{ number_format($book->price, 0, ',', '.') }}
                                                        </p>
                                                    </div>

                                                    <div class="book-select mt-2">
                                                        <input type="checkbox" name="selected_books[]"
                                                            value="{{ $book->id }}" data-price="{{ $book->price }}"
                                                            class="book-checkbox" id="book-{{ $book->id }}">
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-center py-5">
                                                <img src="{{ asset('assets/icons/close.png') }}" alt="No Data"
                                                    width="40">
                                                <p class="mt-2 text-muted">Tidak ada data.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>


                                {{-- Hidden input untuk simpan ringkasan pesanan --}}
                                <input type="hidden" name="total_books" id="totalBooksInput">
                                <input type="hidden" name="total_price" id="totalPriceInput">

                                {{-- Ringkasan --}}
                                <div
                                    class="order-summary-floating p-3 rounded-4 shadow-lg bg-light border d-flex justify-content-between align-items-center flex-wrap">
                                    <div>
                                        <div class="fw-semibold text-muted mb-1" style="font-size: 0.9rem;">Ringkasan
                                            Pesanan</div>
                                        <div class="fs-5 fw-bold text-dark">
                                            <i class="bi bi-journal-bookmark-fill text-primary me-1"></i>
                                            <span>Total Buku: </span><span id="totalBooks">0</span>
                                        </div>
                                        <div class="fs-4 fw-bold text-success mt-1">
                                            <i class="bi bi-cash-coin me-1"></i>
                                            <span>Rp </span><span id="totalPrice">0</span>
                                        </div>
                                    </div>
                                    <button type="submit"
                                        class="btn btn-success px-4 py-2 rounded-pill fw-semibold shadow-sm mt-3 mt-lg-0">
                                        <i class="bi bi-cart-plus-fill me-1"></i> Checkout
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
            </main>
        </div>
    </div>


    {{-- Script untuk menghitung total dan jumlah --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const cards = document.querySelectorAll(".book-card");
            const checkboxes = document.querySelectorAll(".book-checkbox");
            const summary = document.querySelector(".order-summary-floating");
            const totalBooksEl = document.getElementById("totalBooks");
            const totalPriceEl = document.getElementById("totalPrice");

            // Hidden input
            const totalBooksInput = document.getElementById("totalBooksInput");
            const totalPriceInput = document.getElementById("totalPriceInput");

            function updateSummary() {
                let totalBooks = 0;
                let totalPrice = 0;

                checkboxes.forEach(cb => {
                    if (cb.checked) {
                        totalBooks++;
                        totalPrice += parseFloat(cb.dataset.price);
                    }
                });

                totalBooksEl.textContent = totalBooks;
                totalPriceEl.textContent = totalPrice.toLocaleString("id-ID");

                // Isi hidden input
                totalBooksInput.value = totalBooks;
                totalPriceInput.value = totalPrice;

                // Tampilkan ringkasan hanya jika ada buku
                if (totalBooks > 0) {
                    summary.classList.add("show");
                } else {
                    summary.classList.remove("show");
                }
            }

            cards.forEach(card => {
                card.addEventListener("click", function() {
                    const checkbox = this.querySelector(".book-checkbox");
                    checkbox.checked = !checkbox.checked;
                    this.classList.toggle("active", checkbox.checked);
                    updateSummary();
                });
            });
        });
    </script>
@endsection
