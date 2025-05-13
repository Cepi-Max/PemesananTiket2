@extends('admin.layouts.main.app')

@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="row align-items-center justify-content-between">
            <div class="col-md-2 mt-3">
                <a href="{{ route('payment.create') }}" class="btn btn-dark btn-sm d-flex align-items-center justify-content-center w-80">
                    <span>Tambah Pembayaran</span>
                </a>
            </div>
            <div class="col-md-4">
                <form action="{{ route('admin.payments.index') }}" method="GET">
                    <div class="search-container">
                        <input type="text" class="search-input" placeholder="Cari Pembayaran" id="search" name="search" required autocomplete="off">
                        <button class="search-button" type="submit">
                            <i class="fas fa-search"></i>
                            <span>Cari</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Desktop -->
<div class="card shadow d-none d-md-block">
    <div class="card-header bg-dark text-white">
        <h5 class="card-title mb-0">Daftar Pembayaran</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover text-center">
                <thead>
                    @if ($payments->isNotEmpty())
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 20%">User</th>
                        <th style="width: 20%">Metode Pembayaran</th>
                        <th style="width: 15%">Status</th>
                        <th style="width: 15%">Tanggal Pembayaran</th>
                        <th style="width: 20%">Aksi</th>
                    </tr>
                    @endif
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @forelse ($payments as $payment)
                    <tr>
                        <td class="align-middle"><?= $i++; ?></td>
                        <td class="align-middle"><b>{{ $payment->pesanTiket->user->name }}</b></td>
                        <td class="align-middle">{{ $payment->payment_method }}</td>
                        <td class="align-middle">
                            <span class="badge 
                                @if ($payment->payment_status == 'pending') badge-warning 
                                @elseif ($payment->payment_status == 'approved') badge-success 
                                @else badge-danger @endif">
                                {{ ucfirst($payment->payment_status) }}
                            </span>
                        </td>
                        <td class="align-middle">{{ $payment->created_at->format('d F Y') }}</td>
                        <td class="align-middle">
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <a href="{{ route('admin.payment.show', $payment->id) }}" class="btn btn-info btn-sm" title="Lihat Pembayaran" data-bs-toggle="tooltip">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form id="form-approve-{{ $payment->id }}" action="{{ route('admin.payment.update', $payment->id) }}" method="POST" class="d-inline">
                                    @csrf 
                                    @method('PUT')
                                    <button type="submit" name="status" value="approved" class="btn btn-success btn-sm" title="Approve Pembayaran" data-bs-toggle="tooltip">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <form id="form-reject-{{ $payment->id }}" action="{{ route('admin.payment.update', $payment->id) }}" method="POST" class="d-inline">
                                    @csrf 
                                    @method('PUT')
                                    <button type="submit" name="status" value="rejected" class="btn btn-danger btn-sm" title="Tolak Pembayaran" data-bs-toggle="tooltip">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <div class="col-12 text-center py-5">
                        <i class="material-symbols-rounded text-muted mb-3 fs-1">payment</i>
                        <p class="mb-0 text-muted">Tidak ada pembayaran yang ditemukan.</p>
                    </div>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination -->
<div class="mt-3">
    {{ $payments->links() }}
</div>
@endsection
