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
                <div class="card shadow-sm rounded-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-4">Riwayat Pesanan Saya</h4>
                        </div>

                        @if ($orders->isEmpty())
                            <div class="alert alert-info">
                                Belum ada riwayat pesanan.
                            </div>
                        @else
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
                                <table class="table table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Tanggal</th>
                                            <th>Orang Tua</th>
                                            <th>No. HP</th>
                                            <th>Buku</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $index => $order)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                                <td>{{ $order->parent_name }}</td>
                                                <td>{{ $order->parent_phone }}</td>
                                                <td>
                                                    <ul class="mb-0">
                                                        @foreach ($order->details as $detail)
                                                            <li>{{ $detail->book->title }}
                                                                (x{{ $detail->quantity }})
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                                <td>
                                                    @if ($order->status == 'pending')
                                                        <span class="badge bg-warning text-dark">Pending</span>
                                                    @elseif($order->status == 'paid')
                                                        <span class="badge bg-success">Paid</span>
                                                    @elseif($order->status == 'cancelled')
                                                        <span class="badge bg-danger">Cancelled</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
