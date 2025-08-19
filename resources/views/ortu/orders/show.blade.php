@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h3 class="mb-4">Detail Pesanan</h3>

        <div class="row">
            <!-- Bag Section -->
            <div class="col-lg-8">
                <!-- Tambahkan wrapper dengan scroll -->
                <div class="order-items-container border rounded p-3 shadow-sm" style="max-height: 500px; overflow-y: auto;">
                    @foreach ($order->details as $detail)
                        <div class="d-flex mb-4 border-bottom pb-3">
                            <!-- Cover Buku -->
                            <div class="me-3">
                                <img src="{{ asset('storage/' . $detail->book->image) }}" alt="{{ $detail->book->title }}"
                                    width="120" class="rounded shadow-sm">
                            </div>

                            <!-- Informasi Buku -->
                            <div class="flex-grow-1">
                                <h5 class="mb-1">{{ $detail->book->title }}</h5>
                                <p class="fw-bold">Rp {{ number_format($detail->price_each, 0, ',', '.') }}</p>

                                <!-- Aksi Update Jumlah -->
                                <div class="d-flex align-items-center">

                                    <!-- Jumlah -->
                                    <span class="mx-2">Qty: {{ $detail->quantity }}</span>

                                    <!-- Delete -->
                                    <form action="{{ route('orders.deleteItem', [$order->id, $detail->id]) }}"
                                        method="POST" onsubmit="return confirm('Hapus item ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Desktop (tetap di kanan) --}}
            <div class="col-lg-4 d-none d-lg-block">
                <div class="p-4 border rounded shadow-sm position-sticky" style="top: 20px;">
                    <h5 class="mb-3">Summary</h5>
                    <div class="d-flex justify-content-between">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Ongkir</span>
                        <span>Gratis</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Jumlah Buku</span>
                        <span>{{ $order->details->sum('quantity') }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total</span>
                        <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>

                    <div class="mt-4">
                        <a href="#" class="btn btn-primary w-100 mb-2">Buat Pesanan</a>
                        <form action="{{ route('orders.cancel', $order->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin membatalkan pesanan ini? Semua data akan dihapus.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">Batalkan Pesanan</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Mobile & Tablet (sticky bawah) --}}
            <div class="summary-mobile d-lg-none">
                <div class="d-flex justify-content-between">
                    <span>Total</span>
                    <span class="fw-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
                <small class="text-muted">Jumlah Buku: {{ $order->details->sum('quantity') }}</small>
                <div class="mt-2">
                    <a href="#" class="btn btn-primary w-100 mb-2">Buat Pesanan</a>
                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin membatalkan pesanan ini? Semua data akan dihapus.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">Batalkan Pesanan</button>
                    </form>
                </div>
            </div>


        </div>
    </div>
@endsection
