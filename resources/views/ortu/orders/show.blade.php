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
                <div class="p-4 border rounded shadow-sm">
                    <h5 class="mb-3">Summary</h5>
                    <div class="d-flex justify-content-between">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Ongkir</span>
                        <span>Gratis</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total</span>
                        <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between fw-bold mb-4">
                        <span>Jumlah Buku :</span>
                        <span class="text-muted">{{ $order->details->sum('quantity') }}</span>
                    </div>

                    <form action="{{ route('ortu.orders.confirm', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-2">
                            <label class="form-label">Nama Orang Tua</label>
                            <input type="text" name="parent_name" class="form-control" value="{{ old('parent_name') }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nomor HP Orang Tua</label>
                            <input type="text" name="parent_phone" class="form-control"
                                value="{{ old('parent_phone') }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-2">Buat Pesanan</button>
                    </form>

                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin membatalkan pesanan ini? Semua data akan dihapus.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">Batalkan Pesanan</button>
                    </form>
                </div>
            </div>


            <!-- Summary Mobile -->
            <!-- Summary Mini (Fixed Bottom, Mobile Only) -->
            <div class="summary-mini d-lg-none fixed-bottom bg-white border-top p-3 shadow">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small>Total</small><br>
                        <span class="fw-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        <div>
                            <small class="text-muted">Jumlah Buku: {{ $order->details->sum('quantity') }}</small>
                        </div>
                    </div>

                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#checkoutModal">
                        Checkout
                    </button>
                </div>
            </div>

            <!-- Modal Checkout -->
            <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-4 shadow">
                        <div class="modal-header">
                            <h5 class="modal-title" id="checkoutModalLabel">Konfirmasi Pesanan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Ringkasan Pesanan -->
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total</span>
                                <span class="fw-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </div>
                            <small class="text-muted">Jumlah Buku: {{ $order->details->sum('quantity') }}</small>

                            <!-- Form Input -->
                            <form action="{{ route('ortu.orders.confirm', $order->id) }}" method="POST" class="mt-3">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label">Nama Orang Tua</label>
                                    <input type="text" name="parent_name" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nomor HP Orang Tua</label>
                                    <input type="text" name="parent_phone" class="form-control" required>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 mb-2">Buat Pesanan</button>
                            </form>

                            <!-- Batalkan Pesanan -->
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

        </div>
    </div>
@endsection
