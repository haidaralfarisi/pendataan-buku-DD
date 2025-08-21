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

            {{-- Konten utama --}}
            <main class="col-lg-10 px-4 py-4 content-wrapper">
                <h4 class="mb-4">Riwayat Pesanan Saya</h4>

                <div class="row">
                    @forelse ($orders as $order)
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm border-0 rounded-4 h-100">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="fw-semibold mb-1"> Pesanan #{{ $loop->iteration }}</h5>
                                            <p class="text-muted mb-1">Tanggal: {{ $order->created_at->format('d M Y') }}
                                            </p>
                                            <span
                                                class="badge
                                                @if ($order->status == 'pending') bg-warning text-dark
                                                @elseif($order->status == 'paid') bg-success
                                                @elseif($order->status == 'cancelled') bg-danger @endif">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                        <div class="text-end">
                                            <p class="fw-bold text-primary mb-0">
                                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>

                                    <hr>

                                    <p class="mb-2 fw-semibold">Buku:</p>
                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                        @foreach ($order->details->take(3) as $detail)
                                            <div class="text-center">
                                                <img src="{{ asset('storage/' . $detail->book->image) }}"
                                                    alt="{{ $detail->book->title }}" class="img-thumbnail"
                                                    style="width: 70px; height: 100px; object-fit: cover;">
                                                <small class="d-block mt-1 text-truncate" style="max-width: 70px;">
                                                    {{ $detail->book->title }}
                                                </small>
                                            </div>
                                        @endforeach
                                        @if ($order->details->count() > 3)
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-secondary">
                                                    +{{ $order->details->count() - 3 }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    <button class="btn btn-outline-primary btn-sm mt-auto" data-bs-toggle="modal"
                                        data-bs-target="#orderDetail{{ $order->id }}">
                                        Lihat Detail
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Detail (Invoice) -->
                        <div class="modal fade" id="orderDetail{{ $order->id }}" tabindex="-1"
                            aria-labelledby="orderDetailLabel{{ $order->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content rounded-4">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="orderDetailLabel{{ $order->id }}">
                                            Invoice Pesanan #{{ $order->id }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Nama Orang Tua:</strong> {{ $order->parent_name }}</p>
                                        <p><strong>No. HP:</strong> {{ $order->parent_phone }}</p>
                                        <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
                                        <p><strong>Status:</strong>
                                            <span
                                                class="badge
                                                @if ($order->status == 'pending') bg-warning text-dark
                                                @elseif($order->status == 'paid') bg-success
                                                @elseif($order->status == 'cancelled') bg-danger @endif">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </p>

                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Cover</th>
                                                    <th>Buku</th>
                                                    <th>Jumlah</th>
                                                    <th>Harga</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->details as $detail)
                                                    <tr>
                                                        <td>
                                                            <img src="{{ asset('storage/' . $detail->book->image) }}"
                                                                alt="{{ $detail->book->title }}"
                                                                style="width: 50px; height: 70px; object-fit: cover;">
                                                        </td>
                                                        <td>{{ $detail->book->title }}</td>
                                                        <td>x{{ $detail->quantity }}</td>
                                                        <td>Rp {{ number_format($detail->book->price, 0, ',', '.') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <h5 class="text-end mt-3">
                                            Total:
                                            <span class="text-primary">
                                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                            </span>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info">
                            Belum ada riwayat pesanan.
                        </div>
                    @endforelse
                </div>
            </main>
        </div>
    </div>
@endsection
